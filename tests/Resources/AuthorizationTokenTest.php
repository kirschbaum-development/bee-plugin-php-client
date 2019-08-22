<?php

namespace KirschbaumDevelopment\Bee\Tests\Resources;

use PHPUnit\Framework\TestCase;
use KirschbaumDevelopment\Bee\Resources\AuthorizationToken;

/**
 * @coversDefaultClass \KirschbaumDevelopment\Bee\Resources\AuthorizationToken
 */
class AuthorizationTokenTest extends TestCase
{
    /**
     * @covers ::toArray
     */
    public function testToArray()
    {
        $response = [
            'access_token' => 'isufgisufdhguisdfhuisdf.oasihuifghsdif79s87f9sd8f7sd98f7sd98f7dsu89f.owTLmGhqv6ZJSikUhGeLBv-JANoXEAVvMZomivT2o-g',
            'token_type' => 'bearer',
            'expires_in' => 300,
            'refresh_token' => '09a7sd98as7f98ds6f79sd8f.09a8s7da98sd7as98d7as9d8a7s9d8as6d9as86das98d67as.owTLmGhqv6ZJSikUhGeLBv-JANoXEAVvMZomivT2o-g',
        ];

        $token = new AuthorizationToken($response);
        $this->assertEquals($response, $token->toArray());
    }
}
