<?php

namespace App\Services;

use App\Libraries\HttpClient;

class AuthorizationService
{

    /**
     * Authorize
     *
     */
    public static function authorize()
    {
        $url = 'https://run.mocky.io/v3/1f94933c-353c-4ad1-a6a5-a1a5ce2a7abe';

        $response = HttpClient::request('GET', $url);

        return json_decode($response, true);
    }
}
