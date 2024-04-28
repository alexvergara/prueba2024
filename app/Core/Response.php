<?php

class Response
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_INTERNAL_SERVER_ERROR = 500;


    /**
     * Send a JSON response
     * @param mixed $data
     * @param int $status
     */
    public static function json($data, $status = self::STATUS_OK)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }

    /**
     * Send a JSON response with a 404 status
     * @param string $message
     */
    public static function notFound($message = 'Not Found')
    {
        self::json(['message' => $message], self::STATUS_NOT_FOUND);
    }

    /**
     * Send a JSON response with a 500 status
     * @param string $message
     */
    public static function internalServerError($message = 'Internal Server Error')
    {
        self::json(['message' => $message], self::STATUS_INTERNAL_SERVER_ERROR);
    }
}
