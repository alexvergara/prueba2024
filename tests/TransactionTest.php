<?php

use App\Models\Transfer;
use App\Core\Response;

final class TransactionTest extends Test
{
    public function testSameUser(): void
    {
        $data = [
            'payer_id' => 1,
            'payee_id' => 1,
            'amount' => rand(1, 1000),
        ];

        $transferModel = new Transfer();
        $transfer = $transferModel->transfer($data);

        $this->assertEquals($transfer, [['errors' => ['payer_id' => 'Payer and payee cannot be the same']], Response::STATUS_BAD_REQUEST]);
    }

    public function testMerchantCantTransfer(): void
    {
        $data = [
            'payer_id' => 1,
            'payee_id' => 3,
            'amount' => rand(1, 1000),
        ];

        $transferModel = new Transfer();
        $transfer = $transferModel->transfer($data);

        $this->assertEquals($transfer, [['errors' => ['payer_id' => 'Merchant cannot make transfers']], Response::STATUS_BAD_REQUEST]);
    }

    public function testPayerExists(): void
    {
        $data = [
            'payer_id' => 999,
            'payee_id' => 1,
            'amount' => rand(1, 1000),
        ];

        $transferModel = new Transfer();
        $transfer = $transferModel->transfer($data);

        $this->assertEquals($transfer, [['errors' => ['payer_id' => 'Payer not found']], Response::STATUS_NOT_FOUND]);
    }

    public function testPayeeExists(): void
    {
        $data = [
            'payer_id' => 3,
            'payee_id' => 999,
            'amount' => rand(1, 1000),
        ];

        $transferModel = new Transfer();
        $transfer = $transferModel->transfer($data);

        $this->assertEquals($transfer, [['errors' => ['payee_id' => 'Payee not found']], Response::STATUS_NOT_FOUND]);
    }

    public function testEnougBalance(): void
    {
        $data = [
            'payer_id' => 3,
            'payee_id' => 1,
            'amount' => 1000000,
        ];

        $transferModel = new Transfer();
        $transfer = $transferModel->transfer($data);

        $this->assertEquals($transfer, [['errors' => ['payer_id' => 'Insufficient balance']], Response::STATUS_BAD_REQUEST]);
    }


    public function testCanCreateTransaction(): void
    {
        $data = [
            'payer_id' => 3,
            'payee_id' => 1,
            'amount' => rand(1, 1000),
        ];

        $transferModel = new Transfer();
        $transfer = $transferModel->transfer($data);

        $this->assertEquals($transfer, true);
    }
}
