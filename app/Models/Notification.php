<?php

namespace App\Models;

class Notification extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'notifications';

    /**
     * Fillable columns
     * @var array
     */
    protected $accessible = ['transaction_id', 'type', 'status', 'body'];
}
