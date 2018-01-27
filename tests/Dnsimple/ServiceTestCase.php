<?php

//use Dnsimple\Client;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase;

abstract class ServiceTestCase extends TestCase
{
    protected $mockHandler;
    protected $handler;
    protected $client;
    protected $service;

    protected function setUp()
    {
        $this->mockHandler = new MockHandler();
        $this->handler = HandlerStack::create($this->mockHandler);
        $this->client = new Dnsimple\Client("a1b2c3", ['handler' => $this->handler]);
        $this->service = new Dnsimple\IdentityService($this->client);
    }
}
