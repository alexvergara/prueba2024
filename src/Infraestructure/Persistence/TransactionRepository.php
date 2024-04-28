<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Model\Transaction;
use App\Domain\Repository\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    // In a real application, this would likely be replaced with a database connection
    private $transactions = [];

    public function create(Transaction $transaction): void
    {
        // Simulate saving the transaction to a data store
        $this->transactions[] = $transaction;
    }

    public function findLastByUserId(string $userId): ?Transaction
    {
        // Simulate retrieving the last transaction by user ID from a data store
        $lastTransaction = null;
        foreach ($this->transactions as $transaction) {
            if ($transaction->getUserId() === $userId) {
                $lastTransaction = $transaction;
            }
        }
        return $lastTransaction;
    }
}

// Path: src/Domain/Model/Transaction.php
