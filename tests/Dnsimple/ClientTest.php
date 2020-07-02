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
        $response = $this->client->identity->whoami();

        self::assertEquals(4000, $response->getRateLimit());
        self::assertEquals(3991, $response->getRateLimitRemaining());
        self::assertEquals(1450451976, $response->getRateLimitReset());
    }

    public function testDefaultUserAgent()
    {
        self::assertEquals(Client::DEFAULT_USER_AGENT, $this->client->getUserAgent());
    }

    public function testSetUserAgent()
    {
        $this->client->setUserAgent("my-app");

        self::assertEquals("my-app " . Client::DEFAULT_USER_AGENT, $this->client->getUserAgent());
    }
}
