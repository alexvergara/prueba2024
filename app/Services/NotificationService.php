<?php

namespace App\Services;

use App\Libraries\HttpClient;

class NotificationService
{

    /**
     * Send email notification
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public static function sendEmail(string $email, string $message, string $subject): mixed
    {
        $url = 'https://run.mocky.io/v3/6839223e-cd6c-4615-817a-60e06d2b9c82';

        $url .= '?' . http_build_query([ 'email' => $email, 'subject' => $subject, 'message' => $message ]);

        $response = HttpClient::request('GET', $url);

        return json_decode($response, true);
    }

    /**
     * Send SMS notification
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public static function sendSMS(string $phone, string $message): mixed
    {
        $url = 'https://run.mocky.io/v3/6839223e-cd6c-4615-817a-60e06d2b9c82';

        $url .= '?' . http_build_query([ 'phone' => $phone, 'message' => $message ]);

        $response = HttpClient::request('GET', $url);

        return json_decode($response, true);
    }

    /**
     * Notify the user
     * @param string $type
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public static function notify(string $type, string $to, string $message, string $subject = ''): mixed
    {
        if ($type === 'email') {
            return self::sendEmail($to, $subject, $message);
        } else {
            return self::sendSMS($to, $message);
        }
    }
}
