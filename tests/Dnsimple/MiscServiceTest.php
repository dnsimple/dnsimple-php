<?php

use Dnsimple\Client;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;


class MiscServiceTest extends PHPUnit_Framework_TestCase
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
        $this->service = new \Dnsimple\MiscService($this->client);
    }

    /**
     * @group forReal
     */
    public function testWhoamiForReal() {
        $this->client = new Dnsimple\Client(getenv('DNSIMPLE_ACCESS_TOKEN'));
        $service = new \Dnsimple\MiscService($this->client);
        $data = $service->whoami();

        print_r($data);
    }

    public function testWhoami_ReturnsResponse() {
        $this->mockHandler->append(
            new Response(200, [], '{"data":{"user":null,"account":{"id":24,"email":"example-account@example.com"}}}')
        );

        $data = $this->service->whoami();
        $this->assertInstanceOf("stdClass", $data);
        $this->assertObjectHasAttribute("user", $data);
        $this->assertObjectHasAttribute("account", $data);
    }
}
