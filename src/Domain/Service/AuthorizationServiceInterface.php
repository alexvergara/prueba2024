<?php

namespace App\Domain\Service;

interface AuthorizationServiceInterface
{
    /**
     * Authorize the transfer.
     *
     * @param float $amount The amount of money being transferred.
     * @param string $payerId The ID of the user initiating the transfer.
     * @param string $payeeId The ID of the user receiving the transfer.
     * @return bool True if the transfer is authorized, false otherwise.
     */
    public function authorize(float $amount, string $payerId, string $payeeId): bool;
}

// Path: src/Domain/Service/AuthorizationServiceInterface.php
