<?php

namespace App\Domain\Repository;

use App\Domain\Model\Transaction;

interface TransactionRepositoryInterface
{
    public function create(Transaction $transaction): void;

    public function findLastByUserId(string $userId): ?Transaction;
}

// Path: src/Domain/Model/Transaction.php
