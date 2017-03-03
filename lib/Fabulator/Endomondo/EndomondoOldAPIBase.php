<?php

namespace Fabulator\Endomondo;

use Rhumsaa\Uuid\Uuid;
use GuzzleHttp\Client;
use \Psr\Http\Message\ResponseInterface;

class EndomondoOldAPIBase
{
    const API_URL = 'https://api.mobile.endomondo.com';
    const URL_AUTH = '/mobile/auth';
    const USER_AGENT = 'Dalvik/1.4.0 (Linux; U; Android 4.1; GT-B5512 Build/GINGERBREAD)';

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => self::API_URL,
                'headers' => [
                    "User-Agent" => self::USER_AGENT,
                    "Content-Type" => 'application/octet-stream',
                ],
            ]
        );
    }

    /**
     * Request Endomondo old api.
     *
     * @param  string $endpoint
     * @param  array $options
     * @param  string $body
     * @return ResponseInterface
     */
    public function request($endpoint, $options = [], $body = '')
    {

        return $this->client->post(
            $endpoint . '?' . http_build_query($options),
            [
                'body' => $body,
            ]
        );
    }

    /**
     * Request auth token from Endomondo.
     *
     * @param  string $email
     * @param  string $password
     * @return ResponseInterface
     */
    public function requestAuthToken($email, $password)
    {
        return $this->request(self::URL_AUTH, [
            'email' => $email,
            'password' => $password,
            'country' => 'EN',
            'deviceId' => (string) Uuid::uuid5(Uuid::NAMESPACE_DNS, gethostname()),
            'action' => 'PAIR',
        ]);
    }
}