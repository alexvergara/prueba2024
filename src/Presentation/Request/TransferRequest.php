<?php

namespace App\Presentation\Request;

class TransferRequest
{
    private $payerId;
    private $payeeId;
    private $amount;

    public function __construct(string $payerId, string $payeeId, float $amount)
    {
        $this->payerId = $payerId;
        $this->payeeId = $payeeId;
        $this->amount = $amount;
    }

    public function getPayerId(): string
    {
        return $this->payerId;
    }

    public function getPayeeId(): string
    {
        return $this->payeeId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}

// Presentation/Request/TransferRequest.php
