<?php

namespace App\Presentation\Request;

class TransferRequest
{
    private $senderId;
    private $recipientId;
    private $amount;

    public function __construct(string $senderId, string $recipientId, float $amount)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->amount = $amount;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}

// Presentation/Request/TransferRequest.php
