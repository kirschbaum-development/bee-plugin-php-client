<?php

namespace KirschbaumDevelopment\Bee\Resources;

class AuthorizationToken
{
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $tokenType;

    /**
     * @var string
     */
    protected $expiresIn;

    /**
     * @var string
     */
    protected $pageOrientation;

    /**
     * @var string
     */
    protected $refreshToken;

    public function __construct($tokenData)
    {
        $this->accessToken = $tokenData['access_token'] ?? null;
        $this->tokenType = $tokenData['token_type'] ?? null;
        $this->expiresIn = $tokenData['expires_in'] ?? null;
        $this->refreshToken = $tokenData['refresh_token'] ?? null;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @return string
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
