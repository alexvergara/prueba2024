<?php

namespace App\Models;

use PDO;
use App\Core\Database;

class Model
{
    /**
     * Database connection
     */
    private $pdo;

    /**
     * Table name
     */
    protected $table = '';

    /**
     * Fillable columns
     */
    protected $accessible = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    /**
     * Get all records from the table
     * @param int $fetchMode
     * @return mixed
     */
    public function all(int $fetchMode = null): mixed
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll($fetchMode ?: PDO::FETCH_DEFAULT);
    }

    /**
     * Find a record by its ID
     * @param int $id
     * @param array $columns
     * @param int $fetchMode
     * @return mixed
     */
    public function find(int $id, array $columns = ['*'], int $fetchMode = null): mixed
    {
        $query = "SELECT " . implode(',', $columns) . " FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch($fetchMode ?: PDO::FETCH_DEFAULT);
    }

    /**
     * Get all records from the table
     * @param array $conditions
     * @param array $columns
     * @param int $fetchMode
     * @return mixed
     */
    public function get(array $conditions = [], array $columns = ['*'], int $fetchMode = null): mixed
    {
        $query = "SELECT " . implode(',', $columns) . " FROM $this->table";
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll($fetchMode ?: PDO::FETCH_DEFAULT);
    }

    /**
     * Insert a new record
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        // Filter only the accessible columns
        $data = array_intersect_key($data, array_flip($this->accessible));

        // Prepare the query, e.g., INSERT INTO table (column1, column2) VALUES (:column1, :column2)
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_map(function ($value) {
            return ":$value";
        }, array_keys($data)));

        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute($data);
    }

    /**
     * Insert a new record and return the object
     * @param array $data
     * @param int $fetchMode
     * @return mixed
     */
    public function create(array $data, int $fetchMode = null): mixed
    {
        // Filter only the accessible columns
        $data = array_merge($data, ['created_at' => date('Y-m-d H:i:s')]);

        $this->insert($data);

        return $this->find($this->pdo->lastInsertId(), ['*'], $fetchMode ?: PDO::FETCH_DEFAULT);
    }

    /**
     * Update a record
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $set = implode(',', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $query = "UPDATE $this->table SET $set WHERE id = :id";
        var_dump($query);
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':id', $id);

        foreach ($data as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }

        return $stmt->execute();
    }

    /**
     * Update a record and return the object
     * @param int $id
     * @param array $data
     * @param int $fetchMode
     * @return mixed
     */
    public function save(int $id, array $data, int $fetchMode = null): mixed
    {
        $this->update($id, $data);

        return $this->find($id, ['*'], $fetchMode ?: PDO::FETCH_DEFAULT);
    }

    /**
     * Delete a record by its ID
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
