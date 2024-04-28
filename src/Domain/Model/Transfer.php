<?php

namespace App\Domain\Model;

class Transfer
{
    private $payer;
    private $payee;
    private $amount;

    public function __construct(User $payer, User $payee, float $amount, string $status = 'pending')
    {
        $this->payer = $payer;
        $this->payee = $payee;
        $this->amount = $amount;
        $this->status = $status;
    }

    public function getPayer(): User
    {
        return $this->payer;
    }

    public function getPayee(): User
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

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function execute(): void
    {
        $this->payer->withdraw($this->amount);
        $this->payee->deposit($this->amount);
        $this->status = 'completed';
    }

    public function failed(): void
    {
        $this->status = 'failed';
    }
}

// Path: src/Domain/Model/User.php
