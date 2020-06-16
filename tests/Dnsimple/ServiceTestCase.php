<?php
namespace Dnsimple;

use GuzzleHttp;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;

abstract class ServiceTestCase extends TestCase
{
    protected $mockHandler;
    protected $handler;
    protected $client;
    protected $service;

    protected function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $this->handler = HandlerStack::create($this->mockHandler);
        $this->client = new Client("a1b2c3", ['handler' => $this->handler]);
    }

    protected function fixture($fixture): \GuzzleHttp\Psr7\Response
    {
        return GuzzleHttp\Psr7\parse_response(file_get_contents(__DIR__ . "/../fixtures/v2/api/" . $fixture));
    }

    protected function mockResponse($fixture) : void
    {
        $this->mockHandler->append($this->fixture($fixture));
    }
}
