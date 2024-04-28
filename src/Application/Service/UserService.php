<?php

namespace App\Application\Service;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(string $fullName, string $documentId, string $email, string $password): User
    {
        // Check if document ID or email already exists
        if ($this->userRepository->findByDocumentId($documentId) !== null) {
            throw new \Exception('Document ID already exists.');
        }

        if ($this->userRepository->findByEmail($email) !== null) {
            throw new \Exception('Email already exists.');
        }

        // Create new user
        $user = new User($fullName, $documentId, $email, $password);

        // Save user to repository
        $this->userRepository->save($user);

        return $user;
    }
}

