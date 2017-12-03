<?php

namespace Fabulator\Endomondo;

use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class EndomondoOldAPIBase
 * @package Fabulator\Endomondo
 */
class EndomondoOldAPIBase
{
    /**
     * Url of old Endomondo API
     */
    const API_URL = 'https://api.mobile.endomondo.com';

    /**
     * Endomondo endpoint for auth
     */
    const URL_AUTH = '/mobile/auth';

    /**
     * Default user agent.
     */
    const USER_AGENT = 'Dalvik/1.4.0 (Linux; U; Android 4.1; GT-B5512 Build/GINGERBREAD)';

    /**
     * EndomondoOldAPIBase constructor.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => self::API_URL,
                'headers' => [
                    'User-Agent' => self::USER_AGENT,
                    'Content-Type' => 'application/octet-stream',
                ],
            ]
        );
    }

    /**
     * Send request to Endomondo old api.
     *
     * @param  string $endpoint url of endomondo endpoint
     * @param  array $options parameters to send, use authToken parameter for token
     * @param  string $body body to send
     * @return ResponseInterface
     */
    public function send($endpoint, $options = [], $body = '')
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
     * @param  string $email user email
     * @param  string $password user password
     * @return ResponseInterface
     */
    public function requestAuthToken($email, $password)
    {
        return $this->send(self::URL_AUTH, [
            'email' => $email,
            'password' => $password,
            'country' => 'EN',
            'deviceId' => Uuid::uuid5(Uuid::NAMESPACE_DNS, gethostname())->toString(),
            'action' => 'PAIR',
        ]);
    }
}