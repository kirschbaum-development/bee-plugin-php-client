<?php

namespace KirschbaumDevelopment\Bee;

use Psr\SimpleCache\CacheInterface;
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
     * Cache PSR compatible.
     *
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

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
     * Set the cache.
     *
     * @param Psr\SimpleCache\CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Return the 'Authorization' header value.
     *
     * @return string
     */
    public function generateToken()
    {
        if ($this->cache && $this->cache->has($this->getCacheKey())) {
            return new AuthorizationToken($this->cache->get($this->getCacheKey()));
        }

        $response = $this->httpClient->post(static::API_AUTH_URL, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ],
        ]);

        $token = new AuthorizationToken(json_decode($response->getBody()->getContents(), true));

        if ($this->cache) {
            $this->cache->set($this->getCacheKey(), $token->toArray(), ($token->getExpiresIn() - 10));
        }

        return $token;
    }

    protected function getCacheKey()
    {
        return 'bee-plugin.bee-auth.token';
    }
}
