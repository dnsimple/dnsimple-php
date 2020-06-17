<?php

namespace Dnsimple;

final class ClientTest extends ServiceTestCase
{
    public function testConstructor()
    {
        $client = new Client("a1b2c3");
        $this->assertInstanceOf('Dnsimple\Client', $client);
    }

    public function testVersioned_PrependsDefaultVersionToPath()
    {
        $this->assertEquals("/" . Client::API_VERSION . "/test", Client::versioned("/test"));
    }

    public function testRateLimits() {

        $this->mockResponseWith("whoami/success");
        $response = $this->client->Identity->whoami();

        $this->assertEquals(4000, $response->getRateLimit());
        $this->assertEquals(3991, $response->getRateLimitRemaining());
        $this->assertEquals(1450451976, $response->getRateLimitReset());
    }
}
