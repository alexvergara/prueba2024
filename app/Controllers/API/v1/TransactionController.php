<?php

namespace App\Controllers\API\v1;

use App\Models\Transaction;
use App\Core\Request;
use App\Core\Response;

class TransactionController extends Controller
{
    /**
     * The model class name
     * @var string
     */
    protected $model = Transaction::class;


    /**
     * Store data
     */
    public function store(): void
    {
        $data = Request::input();

        $this->model->validate($data);

        $result = $this->model->transaction($data);

        $result === true ? Response::json(['message' => 'Data has been created'], Response::STATUS_CREATED) : $result;
    }
}
