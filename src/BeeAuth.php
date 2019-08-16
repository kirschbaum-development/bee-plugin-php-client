<?php

namespace KirschbaumDevelopment\Bee;

use GuzzleHttp\Client as GuzzleClient;

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
     * Return the default headers.
     *
     * @param array $headers
     * @return array
     */
    protected function formatHeaders($headers = [])
    {
        return array_merge([
            'Authorization' => sprintf('Bearer %s', $this->getAuthorizationHeader()),
        ], $headers);
    }

    /**
     * Return the 'Authorization' header value.
     *
     * @return string
     */
    protected function getAuthorizationHeader()
    {
        $response = $this->httpClient->post(static::API_AUTH_URL, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        $contents = json_decode($response->getBody()->getContents(), true);

        return $contents['access_token'];
    }

    /**
     * Make sure JSON is encoded.
     *
     * @param mixed $json
     * @return string
     */
    protected function encodeJson($json)
    {
        if (is_array($json) || is_object($json)) {
            return json_encode($json);
        }

        return $json;
    }
}
