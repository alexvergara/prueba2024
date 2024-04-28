<?php

namespace App\Core;

use PDO;
// use App\Core\Database;
// use App\Core\Response;

class Validator
{
    /**
     * Validation errors
     * @var array
     */
    protected $errors = [];

    protected $pdo;

    /**
     * Validate the data
     * @param array $data
     * @param string $table
     * @param array $rules
     * @param PDO $pdo
     * @param bool $die
     * @return bool
     */
    public function validate(array $data, $table = null, array $rules = [], PDO $pdo = null, bool $die = false): bool
    {
        $this->pdo = $pdo;

        $_rules = [
            'required' => [fn ($value) => !empty($value), 'The :attribute field is required.'],
            'numeric' => [fn ($value) => is_numeric($value), 'The :attribute field must be a number.'],
            'email' => [fn ($value) => filter_var($value, FILTER_VALIDATE_EMAIL), 'The :attribute field must be a valid email address.'],
            'min' => [fn ($value, $min) => (strlen($value) >= $min), 'The :attribute field must be at least :min characters.'],
            'max' => [fn ($value, $max) => (strlen($value) <= $max), 'The :attribute field may not be greater than :max characters.'],
            'min_value' => [fn ($value, $min) => ($value >= $min), 'The :attribute field must be at least :min.'],
            'max_value' => [fn ($value, $max) => ($value <= $max), 'The :attribute field may not be greater than :max.'],
            'unique' => [fn ($value, $params) => $this->exists($value, $params), 'The :attribute field already exists.']
        ];

        $valid = true;

        foreach ($rules as $key => $rule) {
            $rules = explode('|', $rule);
            foreach ($rules as $rule) {
                $params = explode(':', $rule);
                $rule = array_shift($params);

                if (isset($data[$key]) && $rule !== 'required' && empty($data[$key])) continue;

                $params = array_merge(isset($data[$key]) ? [$data[$key]] : [''], $params);
                if (!call_user_func_array($_rules[$rule][0], $params)) {
                    if (!isset($this->errors[$key])) {
                        $this->errors[$key] = str_replace([':attribute', ':min', ':max'], [$key, isset($params[1]) ? $params[1] : '', isset($params[2]) ? $params[2] : ''], $_rules[$rule][1]);
                    }
                    $valid = false;
                }
            }
        }

        if ($die && !$valid) {
            Response::json(['errors' => $this->errors], Response::STATUS_UNPROCESSABLE_ENTITY);
            die();
        }

        return $valid;
    }

    /**
     * Check if the value exists in the database
     * @param string $model
     * @param string $column
     * @param string $value
     * @return bool
     */
    private function exists(mixed $value, string $params): bool
    {
        $params = explode(',', $params);

        $model = $params[0];
        $column = $params[1];
        $id = $params[2] ?? null;

        $pdo = $this->pdo ?: (new Database())->getConnection();
        $query = $pdo->prepare("SELECT * FROM $model WHERE $column = :value" . ($id ? " AND id != :id" : ''));
        $query->bindParam(':value', $value);
        if ($id) $query->bindParam(':id', $id);
        $query->execute();

        return $query->rowCount() === 0;
    }

    /**
     * Get the validation errors
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }


}
