<?php

namespace App\Infrastructure\Persistence;

//use App\Domain\Model\Transfer;
use App\Domain\Repository\TransferRepositoryInterface;

class TransferRepository extends Repository implements TransferRepositoryInterface
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'transfers';
}

// Path: src/Domain/Model/Transfer.php
