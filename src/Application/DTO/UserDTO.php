<?php

namespace App\Application\DTO;

class UserDTO
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

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }


}

