<?php

namespace Dnsimple\Service;

use Dnsimple\Struct\VanityNameServer;

class VanityNameServersTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new VanityNameServers($this->client);
    }

    public function testEnableVanityNameServers()
    {
        $this->mockResponseWith("enableVanityNameServers/success");

        $vanityNameServers = $this->service->enableVanityNameServers(1010, "example.com")->getData();
        self::assertCount(4, $vanityNameServers);

        $vanityNameServer = $vanityNameServers[0];
        self::assertInstanceOf(VanityNameServer::class, $vanityNameServer);
        self::assertEquals(1, $vanityNameServer->id);
        self::assertEquals("ns1.example.com", $vanityNameServer->name);
        self::assertEquals("127.0.0.1", $vanityNameServer->ipv4);
        self::assertEquals("::1", $vanityNameServer->ipv6);
        self::assertEquals("2016-07-14T13:22:17Z", $vanityNameServer->createdAt);
        self::assertEquals("2016-07-14T13:22:17Z", $vanityNameServer->updatedAt);
    }

    public function testDisableVanityNameServers()
    {
        $this->mockResponseWith("disableVanityNameServers/success");

        $response = $this->service->disableVanityNameServers(1010, "example.com");

        self::assertEquals(204, $response->getStatusCode());
    }
}
