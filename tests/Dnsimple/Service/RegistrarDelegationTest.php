<?php

namespace Dnsimple\Service;

use Dnsimple\Struct\VanityNameServer;

class RegistrarDelegationTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testGetDomainDelegation()
    {
        $this->mockResponseWith("getDomainDelegation/success");
        $delegation = $this->service->getDomainDelegation(1010, "example.com")->getData();

        self::assertEquals(["ns1.dnsimple.com","ns2.dnsimple.com","ns3.dnsimple.com","ns4.dnsimple.com"], $delegation);
    }

    public function testGetEmptyDomainDelegation()
    {
        $this->mockResponseWith("getDomainDelegation/success-empty");
        $delegation = $this->service->getDomainDelegation(1010, "example.com")->getData();

        self::assertEquals([], $delegation);
    }

    public function testChangeDomainDelegation()
    {
        $this->mockResponseWith("changeDomainDelegation/success");

        $attributes = ["ns1.dnsimple.com","ns2.dnsimple.com","ns3.dnsimple.com","ns4.dnsimple.com"];

        $delegation = $this->service->changeDomainDelegation(1010, "example.com", $attributes)->getData();

        self::assertEquals(["ns1.dnsimple.com","ns2.dnsimple.com","ns3.dnsimple.com","ns4.dnsimple.com"], $delegation);
    }

    public function testChangeDomainDelegationToVanity()
    {
        $this->mockResponseWith("changeDomainDelegationToVanity/success");

        $attributes = ["ns1.dnsimple.com","ns2.dnsimple.com"];

        $vanityNameServers = $this->service->changeDomainDelegationToVanity(1010, "example.com", $attributes)->getData();

        self::assertCount(2, $vanityNameServers);

        $vanity = $vanityNameServers[0];
        self::assertInstanceOf(VanityNameServer::class, $vanity);
        self::assertEquals(1, $vanity->id);
        self::assertEquals("ns1.example.com", $vanity->name);
        self::assertEquals("127.0.0.1", $vanity->ipv4);
        self::assertEquals("::1", $vanity->ipv6);
        self::assertEquals("2016-07-11T09:40:19Z", $vanity->createdAt);
        self::assertEquals("2016-07-11T09:40:19Z", $vanity->updatedAt);
    }


    public function testChangeDomainDelegationFromVanity()
    {
        $this->mockResponseWith("changeDomainDelegationFromVanity/success");

        $response = $this->service->changeDomainDelegationFromVanity(1010, "example.com");

        self::assertEquals(204, $response->getStatusCode());
    }
}
