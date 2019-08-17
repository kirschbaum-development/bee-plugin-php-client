<?php

namespace KirschbaumDevelopment\Bee\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use KirschbaumDevelopment\Bee\BeeAuth;
use KirschbaumDevelopment\Bee\Resources\AuthorizationToken;

/**
 * @coversDefaultClass \KirschbaumDevelopment\Bee\BeeAuth
 */
class BeeAuthTest extends TestCase
{
    /**
     * @covers ::generateToken
     */
    public function testGenerateToken()
    {
        $response = [
            'access_token' => 'isufgisufdhguisdfhuisdf.oasihuifghsdif79s87f9sd8f7sd98f7sd98f7dsu89f.owTLmGhqv6ZJSikUhGeLBv-JANoXEAVvMZomivT2o-g',
            'token_type' => 'bearer',
            'expires_in' => 300,
            'refresh_token' => '09a7sd98as7f98ds6f79sd8f.09a8s7da98sd7as98d7as9d8a7s9d8as6d9as86das98d67as.owTLmGhqv6ZJSikUhGeLBv-JANoXEAVvMZomivT2o-g',
            'as:client_id' => 'da91fe57-1ca6-4dba-b557-61edb96f4149',
            'userName' => 'Tn3KV7JYavWn',
            'as:region' => 'eu-west-1',
            '.issued' => 'Sat, 17 Aug 2019 00:08:50 GMT',
            '.expires' => 'Sat, 17 Aug 2019 00:13:50 GMT'
        ];

        $mock = new MockHandler([new Response(200, [], json_encode($response))]);
        $guzzleClient = new Client(['handler' => HandlerStack::create($mock)]);

        $beeClient = new BeeAuth($guzzleClient);
        $beeClient->setClientId('fake-client-id');
        $beeClient->setClientSecret('fake-client-secret');
        $token = $beeClient->generateToken();

        $this->assertInstanceOf(AuthorizationToken::class, $token);
        $this->assertEquals($response['access_token'], $token->getAccessToken());
        $this->assertEquals($response['token_type'], $token->getTokenType());
        $this->assertEquals($response['expires_in'], $token->getExpiresIn());
        $this->assertEquals($response['refresh_token'], $token->getRefreshToken());
    }
}
