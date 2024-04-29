<?php

namespace App\Domain\Model;

class User
{
    private $fullName;
    private $documentId;
    private $email;
    private $password;
    private $role;
    private $balance;

    public function __construct(string $fullName, string $documentId, string $email, string $password, string $role = 'user', float $balance = 0)
    {
        $this->fullName = $fullName;
        $this->documentId = $documentId;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->balance = $balance;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function setDocumentId(string $documentId): void
    {
        $this->documentId = $documentId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        $this->balance -= $amount;
    }

    public function transfer(User $payee, float $amount): void
    {
        $this->withdraw($amount);
        $payee->deposit($amount);
    }

    public function canTransfer(float $amount): bool
    {
        return $this->balance >= $amount;
    }

    public function isMerchant(): bool
    {
        return $this->role === 'merchant';
    }
}

// Path: src/Domain/Model/User.php
