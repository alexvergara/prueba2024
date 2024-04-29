<?php

namespace App\Infrastructure\ExternalService;

class AuthorizationService
{
    public function authorize(float $amount, string $payerId, string $payeeId): bool
    {
        // Simulate authorization logic
        // In a real application, this would interact with an external authorization service
        // For simplicity, always return true in this example
        return true;
    }
}
