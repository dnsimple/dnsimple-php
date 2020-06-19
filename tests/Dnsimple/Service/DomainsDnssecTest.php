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

        self::assertTrue($dnssec->enabled);
        self::assertEquals("2017-03-03T13:49:58Z", $dnssec->createdAt);
        self::assertEquals("2017-03-03T13:49:58Z", $dnssec->updatedAt);
    }

    public function testDisableDnssec()
    {
        $this->mockResponseWith("disableDnssec/success");
        $response = $this->service->disableDnssec(1010, 1);

        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(204, $response->getStatusCode());
    }

    public function testGetDnssec()
    {
        $this->mockResponseWith("getDnssec/success");
        $dnssec = $this->service->getDnssec(1010, 1)->getData();

        self::assertTrue($dnssec->enabled);
        self::assertEquals("2017-02-03T17:43:22Z", $dnssec->createdAt);
        self::assertEquals("2017-02-03T17:43:22Z", $dnssec->updatedAt);
    }
}
