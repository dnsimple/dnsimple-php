<?php

namespace Dnsimple;

use Dnsimple\Service\ServiceTestCase;

final class ClientTest extends ServiceTestCase
{
    public function testConstructor()
    {
        $client = new Client("a1b2c3");
        self::assertInstanceOf(Client::class, $client);
    }

    public function testVersionedPrependsDefaultVersionToPath()
    {
        self::assertEquals("/" . Client::API_VERSION . "/test", Client::versioned("/test"));
    }

    public function testRateLimits() {

        $this->mockResponseWith("whoami/success");
        $response = $this->client->Identity->whoami();

        self::assertEquals(4000, $response->getRateLimit());
        self::assertEquals(3991, $response->getRateLimitRemaining());
        self::assertEquals(1450451976, $response->getRateLimitReset());
    }
}
