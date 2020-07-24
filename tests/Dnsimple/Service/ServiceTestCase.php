<?php
namespace Dnsimple\Service;

use Dnsimple\Client;
use GuzzleHttp;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
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
        $this->client = new Client("a1b2c3", ["handler" => $this->handler]);
    }

    protected function fixture($fixture): Response
    {
        return GuzzleHttp\Psr7\parse_response(file_get_contents(__DIR__ . "/../../fixtures/v2/api/" . $fixture . ".http"));
    }

    protected function mockResponseWith($fixture) : void
    {
        $this->mockHandler->append($this->fixture($fixture));
    }

    protected function queryContent()
    {
        return $this->mockHandler->getLastRequest()->getUri()->getQuery();
    }
}
