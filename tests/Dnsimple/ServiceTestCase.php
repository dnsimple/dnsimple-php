<?php

//use Dnsimple\Client;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;


abstract class ServiceTestCase extends \PHPUnit_Framework_TestCase
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
        $this->service = new Dnsimple\MiscService($this->client);
    }
}
