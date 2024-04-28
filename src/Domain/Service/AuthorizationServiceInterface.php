<?php

namespace App\Domain\Service;

interface AuthorizationServiceInterface
{
    /**
     * Authorize the transaction.
     *
     * @param float $amount The amount of money being transferred.
     * @param string $senderId The ID of the user initiating the transfer.
     * @param string $recipientId The ID of the user receiving the transfer.
     * @return bool True if the transaction is authorized, false otherwise.
     */
    public function authorize(float $amount, string $senderId, string $recipientId): bool;
}

// Path: src/Domain/Service/AuthorizationServiceInterface.php
