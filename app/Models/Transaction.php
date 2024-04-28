<?php

namespace App\Models;

use App\Core\Response;
use App\Services\Authorization;

class Transaction extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'transactions';

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
     * Make a transaction
     * @param array $data
     * @return mixed
     */
    public function transaction($data)
    {
        $user = new User($this->pdo);

        // TODO: Move to a validation handler

        // Payer validations
        $payer = $user->find($data['payer_id']);

        if (!$payer) {
            return Response::json(['errors' => ['payer_id' => 'Payer not found']], Response::STATUS_NOT_FOUND);
        }
        if ($payer['id'] == $data['payee_id']) {
            return Response::json(['errors' => ['payer_id' => 'Payer and payee cannot be the same']], Response::STATUS_BAD_REQUEST);
        }
        if ($payer['role'] === 'merchant') {
            return Response::json(['errors' => ['payer_id' => 'Merchant cannot make transactions']], Response::STATUS_BAD_REQUEST);
        }
        if ($payer['balance'] < $data['amount']) {
            return Response::json(['errors' => ['payer_id' => 'Insufficient balance']], Response::STATUS_BAD_REQUEST);
        }

        // Payee validations
        $payee = $user->find($data['payee_id']);
        if (!$payee) {
            return Response::json(['payee_id' => ['payer_id' => 'Payee not found']], Response::STATUS_NOT_FOUND);
        }

        //-------------------/

        // Transaction
        $this->pdo->beginTransaction();
        try {
            $authorization = Authorization::authorize(); // Authorize the transaction

            if (!$authorization || $authorization['message'] !== 'Autorizado') {
                $this->pdo->rollBack();
                return Response::json(['errors' => ['authorization' => 'Transaction not authorized']], Response::STATUS_FORBIDDEN);
            }

            $payer['balance'] -= $data['amount'];
            $payee['balance'] += $data['amount'];

            $user->update($payer['id'], ['balance' => $payer['balance']]); // Update the payer balance
            $user->update($payee['id'], ['balance' => $payee['balance']]); // Update the payee balance

            $transaction = $this->create([
                'payer_id' => $payer['id'],
                'payee_id' => $payee['id'],
                'amount' => $data['amount']
            ]);

            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return Response::internalServerError($e->getMessage());
        }

        return true;
    }
}
