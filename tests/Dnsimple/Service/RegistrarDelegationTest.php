<?php

namespace Dnsimple\Service;

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

    public function testChangeDomainDelegationFromVanity()
    {
        $this->mockResponseWith("changeDomainDelegationFromVanity/success");

        $response = $this->service->changeDomainDelegationFromVanity(1010, "example.com");

        self::assertEquals(204, $response->getStatusCode());
    }
}
