<?php

namespace KirschbaumDevelopment\Bee;

use GuzzleHttp\Client as GuzzleClient;
use KirschbaumDevelopment\Bee\Resources\AuthorizationToken;

class BeeAuth
{
    const API_AUTH_URL = 'https://auth.getbee.io/apiauth';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @param \GuzzleHttp\Client $httpClient
     */
    public function __construct(GuzzleClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Set client ID.
     *
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Set client secret.
     *
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * Return the 'Authorization' header value.
     *
     * @return string
     */
    public function generateToken()
    {
        $response = $this->httpClient->post(static::API_AUTH_URL, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ],
        ]);

        return new AuthorizationToken(json_decode($response->getBody()->getContents(), true));
    }
}
