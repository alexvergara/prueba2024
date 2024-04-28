<?php

namespace App\Controllers\API\v1;

use App\Core\Request;

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
    public function index()
    {
        $data = $this->model->all();
        Response::json($data);
    }

    /**
     * Get data by id
     * @param $id
     */
    public function show($id)
    {
        $data = $this->model->find($id);
        Response::json($data);
    }

    /**
     * Store data
     */
    public function store()
    {
        $data = Request::input();

        $this->model->validate($data);

        $this->model->create($data);
        Response::json(['message' => 'Data has been created'], Response::HTTP_CREATED);
    }

    /**
     * Update data by id
     * @param $id
     */
    public function update($id)
    {
        $data = Request::input();

        $this->model->validate($data);

        $this->model->find($id)->update($data);
        Response::json(['message' => 'Data has been updated'], Response::HTTP_ACCEPTED);
    }

    /**
     * Delete data by id
     * @param $id
     */
    public function destroy($id)
    {
        $this->model->destroy($id);
        Response::json(['message' => 'Data has been deleted'], Response::HTTP_ACCEPTED);
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