<?php

namespace App\Application\Service;

use App\Domain\Model\User;
use App\Domain\Model\Transfer;
use App\Domain\Service\AuthorizationServiceInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Repository\TransferRepositoryInterface;

class TransferService
{
    private $authorizationService;
    private $userRepository;
    private $transferRepository;

    public function __construct(
        AuthorizationServiceInterface $authorizationService,
        UserRepositoryInterface $userRepository,
        TransferRepositoryInterface $transferRepository
    ) {
        $this->authorizationService = $authorizationService;
        $this->userRepository = $userRepository;
        $this->transferRepository = $transferRepository;
    }

    public function transfer(string $senderId, string $recipientId, float $amount): void
    {
        // Retrieve sender and recipient from repository
        $sender = $this->userRepository->findById($senderId);
        $recipient = $this->userRepository->findById($recipientId);

        // Check if sender and recipient exist
        if (!$sender || !$recipient) {
            throw new \Exception('Sender or recipient not found.');
        }

        // Check if sender has sufficient balance
        if ($sender->getBalance() < $amount) {
            throw new \Exception('Insufficient balance.');
        }

        // Authorize the transaction
        $isAuthorized = $this->authorizationService->authorize($amount, $senderId, $recipientId);
        if (!$isAuthorized) {
            throw new \Exception('Transaction not authorized.');
        }

        // Create transfer
        $transfer = new Transfer($sender, $recipient, $amount);

        // Save transfer to repository
        $this->transferRepository->create($transfer);

        // Update sender's balance
        $sender->decreaseBalance($amount);
        $this->userRepository->save($sender);

        // Update recipient's balance
        $recipient->increaseBalance($amount);
        $this->userRepository->save($recipient);
    }
}
