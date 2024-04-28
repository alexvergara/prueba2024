<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    // In a real application, this would likely be replaced with a database connection
    private $users = [];

    public function save(User $user): void
    {
        // Simulate saving the user to a data store
        $this->users[$user->getId()] = $user;
    }

    public function findById(string $id): ?User
    {
        // Simulate retrieving a user by ID from a data store
        return $this->users[$id] ?? null;
    }

    public function findByDocumentId(string $documentId): ?User
    {
        // Simulate retrieving a user by document ID from a data store
        foreach ($this->users as $user) {
            if ($user->getDocumentId() === $documentId) {
                return $user;
            }
        }
        return null;
    }

    public function findByEmail(string $email): ?User
    {
        // Simulate retrieving a user by email from a data store
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }
}

// Path: src/Domain/Model/User.php
