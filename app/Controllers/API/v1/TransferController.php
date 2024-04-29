<?php

namespace App\Controllers\API\v1;

use App\Models\Transfer;
use App\Core\Request;
use App\Core\Response;

class TransferController extends Controller
{
    /**
     * The model class name
     * @var string
     */
    protected $model = Transfer::class;


    /**
     * Store data
     */
    public function store(): void
    {
        $data = Request::input();

        $this->model->validate($data);

        $result = $this->model->transfer($data);

        if ($result === true) {
            Response::json(['message' => 'Data has been created'], Response::STATUS_CREATED);
        }

        Response::json($result[0], $result[1]);
    }
}
