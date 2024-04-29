<?php

namespace App\Infrastructure\Persistence;

//use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'users';
}

// Path: src/Domain/Model/User.php
