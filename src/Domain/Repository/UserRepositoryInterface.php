<?php

namespace App\Domain\Repository;

use App\Domain\Model\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(string $id): ?User;

    public function findByDocumentId(string $documentId): ?User;

    public function findByEmail(string $email): ?User;
}

// Path: src/Domain/Repository/UserRepositoryInterface.php
