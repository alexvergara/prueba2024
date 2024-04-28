<?php

namespace App\Models;

class User extends Model
{
    protected $table = 'users';

    protected $accessible = ['identification', 'full_name', 'email', 'password', 'role', 'balance'];

    public $rules = [
        'identification' => 'required|numeric|unique:users,identification',
        'full_name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        'role' => 'required',
        'balance' => 'required|numeric'
    ];

}
