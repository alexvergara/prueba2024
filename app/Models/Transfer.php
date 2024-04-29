<?php

namespace App\Models;

use App\Core\Response;
use App\Services\NotificationService;
use App\Services\AuthorizationService;

class Transfer extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'transfers';

    /**
     * Fillable columns
     * @var array
     */
    protected $accessible = ['payer_id', 'payee_id', 'amount', 'status'];

    /**
     * Validation rules
     * @var array
     */
    public $rules = [
        'payer_id' => 'required|numeric|exists:users,id',
        'payee_id' => 'required|numeric|exists:users,id',
        'amount' => 'required|numeric|min:0',
    ];



    /**
     * Make a transfer
     * @param array $data
     * @return mixed
     */
    public function transfer($data)
    {
        $user = new User($this->pdo);

        // TODO: Move to a validation handler

        // Payer validations
        $payer = $user->find($data['payer_id']);

        if (!$payer) {
            return [['errors' => ['payer_id' => 'Payer not found']], Response::STATUS_NOT_FOUND];
        }
        if ($payer['id'] == $data['payee_id']) {
            return [['errors' => ['payer_id' => 'Payer and payee cannot be the same']], Response::STATUS_BAD_REQUEST];
        }
        if ($payer['role'] === 'merchant') {
            return [['errors' => ['payer_id' => 'Merchant cannot make transfers']], Response::STATUS_BAD_REQUEST];
        }
        if ($payer['balance'] < $data['amount']) {
            return [['errors' => ['payer_id' => 'Insufficient balance']], Response::STATUS_BAD_REQUEST];
        }

        // Payee validations
        $payee = $user->find($data['payee_id']);
        if (!$payee) {
            return [['errors' => ['payee_id' => 'Payee not found']], Response::STATUS_NOT_FOUND];
        }

        //-------------------/

        // Transfer
        $transfer = false;
        $this->pdo->beginTransaction();
        try {
            $authorization = AuthorizationService::authorize(); // Authorize the transfer

            if (!$authorization || $authorization['message'] !== 'Autorizado') {
                $this->pdo->rollBack();
                return [['errors' => ['authorization' => 'Transfer not authorized']], Response::STATUS_FORBIDDEN];
            }

            $payer['balance'] -= $data['amount'];
            $payee['balance'] += $data['amount'];

            $user->update($payer['id'], ['balance' => $payer['balance']]); // Update the payer balance
            $user->update($payee['id'], ['balance' => $payee['balance']]); // Update the payee balance

            $transfer = $this->create([
                'payer_id' => $payer['id'],
                'payee_id' => $payee['id'],
                'amount' => $data['amount']
            ]);

            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return [$e->getMessage(), Response::STATUS_INTERNAL_SERVER_ERROR];
        }

        if ($transfer) {
            // Send notification
            $body = "Hi {$payee['full_name']}, you have received {$data['amount']} from {$payer['full_name']}";

            // TODO: Validate if the user wants to receive notifications by email or SMS
            $type = 'email'; // TODO: Add phone number to the user table and notification type
            try {
                $notification = new Notification($this->pdo);
                $new_notification = $notification->create([
                    'transfer_id' => $transfer['id'],
                    'type' => $type,
                    'body' => $body,
                ]);

                $notified = NotificationService::notify($type, $payee['email'], $body, 'Transfer Received');

                $status = ($notified && $notified['message']) ? 'completed' : 'failed';
                $notification->save($new_notification['id'], ['status' => $status]);

                //TODO: Create process to retry the notification when pending/failed
            } catch (\Exception $e) {
                // TODO: Log the error
            }
        }

        return true;
    }
}
