<?php

namespace Dnsimple\Service;

use Dnsimple\Response;

class DomainsDnssecTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DomainsService($this->client);
    }

    public function testEnableDnssec()
    {
        $this->mockResponseWith("enableDnssec/success");
        $dnssec = $this->service->enableDnssec(1010, 1)->getData();

        $this->assertTrue($dnssec->enabled);
        $this->assertEquals("2017-03-03T13:49:58Z", $dnssec->createdAt);
        $this->assertEquals("2017-03-03T13:49:58Z", $dnssec->updatedAt);
    }

    public function testDisableDnssec()
    {
        $this->mockResponseWith("disableDnssec/success");
        $response = $this->service->disableDnssec(1010, 1);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testGetDnssec()
    {
        $this->mockResponseWith("getDnssec/success");
        $dnssec = $this->service->getDnssec(1010, 1)->getData();

        $this->assertTrue($dnssec->enabled);
        $this->assertEquals("2017-02-03T17:43:22Z", $dnssec->createdAt);
        $this->assertEquals("2017-02-03T17:43:22Z", $dnssec->updatedAt);
    }
}
