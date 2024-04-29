<?php

namespace App\Domain\Repository;

use App\Domain\Model\Transfer;

interface TransferRepositoryInterface
{
    public function create(Transfer $transfer): void;

    public function findLastByUserId(string $userId): ?Transfer;
}

// Path: src/Domain/Model/Transfer.php
