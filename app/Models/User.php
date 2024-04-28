<?php

namespace App\Models;

class User extends Model
{
    protected $table = 'users';

    protected $accessible = ['identification', 'full_name', 'email', 'password', 'role', 'balance'];

}
