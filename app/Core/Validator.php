<?php

namespace App\Core;

class Validator
{
    /**
     * Validation rules
     * @var array
     */
    public $rules = [
        'required' => ($value) => !empty($value),
        'email' => ($value) => filter_var($value, FILTER_VALIDATE_EMAIL),
        'min' => ($value, $min) => strlen($value) >= $min,
        'max' => ($value, $max) => strlen($value) <= $max,
        'unique' => ($value, $table, $column) => $this->exists($model, $column, $value),
    ];

    /**
     * Validate the data
     * @param array $data
     * @param array $rules
     * @return bool
     */
    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $key => $rule) {
            $rules = explode('|', $rule);
            foreach ($rules as $rule) {
                $params = explode(':', $rule);
                $rule = array_shift($params);
                $params = array_merge([$data[$key]], $params);
                if (!call_user_func_array($this->rules[$rule], $params)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check if the value exists in the database
     * @param string $model
     * @param string $column
     * @param string $value
     * @return bool
     */
    private function exists($model, $column, $value)
    {
        $pdo = (new Database())->getConnection();
        $query = $pdo->prepare("SELECT * FROM $model WHERE $column = :value");
        $query->execute(['value' => $value]);
        return $query->rowCount() === 0;
    }
}
