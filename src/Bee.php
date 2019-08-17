<?php

namespace KirschbaumDevelopment\Bee;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use KirschbaumDevelopment\Bee\Resources\Pdf;

class Bee
{
    const API_BASE_URL = 'https://api.getbee.io/v1/message';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * The API token.
     *
     * @var string
     */
    protected $apiToken;

    /**
     * @param \GuzzleHttp\Client $httpClient
     */
    public function __construct(GuzzleClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Set the API token.
     *
     * @param string $clientId
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * Message API: Generate HTML from the JSON content.
     *
     * @param array $json
     * @return string
     */
    public function html(array $json)
    {
        $response = $this->httpClient->post(
            sprintf('%s/html', static::API_BASE_URL),
            [
                'headers' => $this->formatHeaders([
                    'Content-Type' => 'application/json',
                ]),
                'json' => $json,
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * Message API: Generate PDF from the JSON content.
     *
     * @param array $payload
     * @return string
     */
    public function pdf(array $payload)
    {
        if (! isset($payload['html'])) {
            throw new Exception('"html" parameter is required to generate PDFs');
        }

        $response = $this->httpClient->post(
            sprintf('%s/pdf', static::API_BASE_URL),
            [
                'headers' => $this->formatHeaders([
                    'Content-Type' => 'application/json',
                ]),
                'json' => $payload,
            ]
        );

        return new Pdf(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * Message API: Generate image from the JSON content.
     *
     * @param array $payload
     * @return string
     */
    public function image(array $payload)
    {
        $response = $this->httpClient->post(
            sprintf('%s/image', static::API_BASE_URL),
            [
                'headers' => $this->formatHeaders([
                    'Content-Type' => 'application/json',
                ]),
                'json' => $payload,
            ]
        );

        return $response->getBody();
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
            'Authorization' => sprintf('Bearer %s', $this->apiToken),
        ], $headers);
    }
}
