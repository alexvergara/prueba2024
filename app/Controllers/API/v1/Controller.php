<?php

namespace App\Controllers\API\v1;

use App\Core\Request;
use App\Core\Response;

class Controller
{
    /**
     * The model class name
     * @var string
     */
    protected $model;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->model = new ($this->model ?: $this->getModel());
    }

    /**
     * Get all data
     */
    public function index(): void
    {
        $data = $this->model->all();

        Response::json($data);
    }

    /**
     * Get data by id
     * @param $id int
     */
    public function show(int $id): void
    {
        $data = $this->model->find($id);

        Response::json($data);
    }

    /**
     * Store data
     */
    public function store(): void
    {
        $data = Request::input();

        $this->model->validate($data);

        $this->model->create($data);
        Response::json(['message' => 'Data has been created'], Response::STATUS_CREATED);
    }

    /**
     * Update data by id
     * @param $id int
     */
    public function update(int $id): void
    {
        $data = Request::input();

        $rules = $this->model->rules;
        $rules['email'] .= $id;
        $rules['identification'] .= $id;

        $this->model->validate($data, false, true, $rules);

        $this->model->update($id, $data);
        Response::json(['message' => 'Data has been updated'], Response::STATUS_OK);
    }

    /**
     * Delete data by id
     * @param $id int
     */
    public function destroy(int $id): void
    {
        $this->model->destroy($id);
        Response::json(['message' => 'Data has been deleted'], Response::STATUS_OK);
    }

    /**
     * Get the model class name based on the controller class name
     * @return string
     */
    protected function getModel()
    {
        $class = explode('\\', get_class($this));
        $class = end($class);
        $class = str_replace('Controller', '', $class);
        $class = 'App\Models\\' . $class;
        return $class;
    }
}

// Path: app/Controllers/API/v1/Controller.php
