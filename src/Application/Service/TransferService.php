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

    public function transfer(string $payerId, string $payeeId, float $amount): void
    {
        // Retrieve payer and payee from repository
        $payer = $this->userRepository->findById($payerId);
        $payee = $this->userRepository->findById($payeeId);

        // Check if payer and payee exist
        if (!$payer || !$payee) {
            throw new \Exception('Payer or payee not found.');
        }

        // Check if payer has sufficient balance
        if ($payer->getBalance() < $amount) {
            throw new \Exception('Insufficient balance.');
        }

        // Authorize the transfer
        $isAuthorized = $this->authorizationService->authorize($amount, $payerId, $payeeId);
        if (!$isAuthorized) {
            throw new \Exception('Transfer not authorized.');
        }

        // Create transfer
        $transfer = new Transfer($payer, $payee, $amount);

        // Save transfer to repository
        $this->transferRepository->create($transfer);

        // Update payer's balance
        $payer->decreaseBalance($amount);
        $this->userRepository->save($payer);

        // Update payee's balance
        $payee->increaseBalance($amount);
        $this->userRepository->save($payee);
    }
}
