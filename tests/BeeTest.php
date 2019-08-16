<?php

namespace KirschbaumDevelopment\Bee\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use KirschbaumDevelopment\Bee\Bee;

/**
 * @coversDefaultClass \KirschbaumDevelopment\Bee\Bee
 */
class BeeTest extends TestCase
{
    /**
     * @covers ::html
     */
    public function testHtml()
    {
        $html = '<h1>Hello Bee.</h1>';

        $mock = new MockHandler([new Response(200, [], $html)]);
        $guzzleClient = new Client(['handler' => HandlerStack::create($mock)]);

        $beeClient = new Bee($guzzleClient);
        $this->assertEquals($html, $beeClient->html(['page' => []]));
    }

    /**
     * @covers ::pdf
     */
    public function testPdf()
    {
        $html = '<h1>Hello Bee.</h1>';
        $response = [
            'url' => 'https://www.google.com/file.pdf',
            'filename' => 'file.pdf',
            'page_size' => 'full',
            'page_orientation' => 'portrait',
            'content_type' => 'application/pdf'
        ];

        $mock = new MockHandler([new Response(200, [], json_encode($response))]);
        $guzzleClient = new Client(['handler' => HandlerStack::create($mock)]);

        $beeClient = new Bee($guzzleClient);
        $this->assertEquals($response, $beeClient->pdf([
            'html' => $html,
        ]));
    }

    /**
     * @covers ::image
     */
    public function testImage()
    {
        $html = '<h1>Hello Bee.</h1>';
        $response = 'raw image data here';

        $mock = new MockHandler([new Response(200, [], $response)]);
        $guzzleClient = new Client(['handler' => HandlerStack::create($mock)]);

        $beeClient = new Bee($guzzleClient);
        $this->assertEquals($response, $beeClient->image([
            'html' => $html,
        ]));
    }
}
