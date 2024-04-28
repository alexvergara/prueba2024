<?php

namespace App\Application\DTO;

class TransferDTO
{
    private $payer;
    private $payee;
    private $amount;
    private $status;

    public function __construct(string $payer, string $payee, float $amount, string $status = 'pending')
    {
        $this->payer = $payer;
        $this->payee = $payee;
        $this->amount = $amount;
        $this->status = $status;
    }

    public function getPayer(): string
    {
        return $this->payer;
    }

    public function getPayee(): string
    {
        return $this->payee;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
