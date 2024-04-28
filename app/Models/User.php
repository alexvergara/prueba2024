<?php

namespace App\Models;

class User extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'users';

    /**
     * Fillable columns
     * @var array
     */
    protected $accessible = ['identification', 'full_name', 'email', 'password', 'role', 'balance'];

    /**
     * Validation rules
     * @var array
     */
    public $rules = [
        'identification' => 'required|numeric|unique:users,identification,',
        'full_name' => 'required',
        'email' => 'required|email|unique:users,email,',
        'password' => 'required|min:6|max:20',
        'role' => 'included:merchant,user',
        'balance' => 'numeric'
    ];

    /**
     * Parse the data before validation
     * @param array $data
     * @return array
     */
    public function parse_data($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}
