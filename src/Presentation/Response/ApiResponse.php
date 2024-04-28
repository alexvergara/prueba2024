<?php

namespace App\Presentation\Response;

class ApiResponse
{
    private $statusCode;
    private $data;

    public function __construct(int $statusCode, $data = null)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData()
    {
        return $this->data;
    }
}

// Presentation/Response/ApiResponse.php
