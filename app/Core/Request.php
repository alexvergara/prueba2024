<?php

namespace App\Core;

class Request
{
    /**
     * Get the request method
     * @return string
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get the request URI
     * @return string
     */
    public static function uri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get the request headers
     * @return array
     */
    public static function headers(): array
    {
        return getallheaders();
    }

    /**
     * Get the request body
     * @return array
     */
    public static function input(mixed $attributes = null): array
    {
        // Retrieve the raw POST data
        $jsonData = file_get_contents('php://input');

        // Decode the JSON data into a PHP associative array
        $data = json_decode($jsonData, true);

        // If the $attributes parameter is an array, return only the specified attributes
        if (is_array($attributes)) {
            return array_intersect_key($data, array_flip($attributes));
        } else if (is_string($attributes)) {
            // If the $attributes parameter is a string, return only the specified attribute
            return $data[$attributes];
        }

        // If the $attributes parameter is not specified, return all attributes
        return $data;
    }
}

