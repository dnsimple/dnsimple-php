<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Zone;

class ZonesTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Zones($this->client);
    }

    public function testListZones()
    {
        $this->mockResponseWith("listZones/success");

        $response = $this->service->listZones(1010);
        self::assertInstanceOf(Response::class, $response);

        $data = $response->getData();
        self::assertCount(2, $data);

        $zone = $data[0];
        self::assertInstanceOf(Zone::class, $zone);
        self::assertEquals(1, $zone->id);
    }

    public function testListZonesSupportsFilters()
    {
        $this->mockResponseWith("listZones/success");
        $this->service->listZones(1010, ["name_like" => "example-alpha.com"]);

        self::assertEquals("name_like=example-alpha.com", $this->queryContent());
    }

    public function testListZonesSupportsSorting()
    {
        $this->mockResponseWith("listZones/success");
        $this->service->listZones(1010, ["sort" => "id:asc,name:desc"]);

        self::assertEquals("sort=id%3Aasc%2Cname%3Adesc", $this->queryContent());
    }

    public function testListZonesHasPaginationObject()
    {
        $this->mockResponseWith("listZones/success");
        $response = $this->service->listZones(1010);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListZonesSupportsPagination()
    {
        $this->mockResponseWith("listZones/success");
        $this->service->listZones(1010, ["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testGetZone()
    {
        $this->mockResponseWith("getZone/success");
        $zone = $this->service->getZone(1010, "example-alpha.com")->getData();

        self::assertEquals(1, $zone->id);
        self::assertEquals(1010, $zone->accountId);
        self::assertEquals("example-alpha.com", $zone->name);
        self::assertFalse($zone->reverse);
        self::assertFalse($zone->secondary);
        self::assertNull($zone->lastTransferredAt);
        self::assertTrue($zone->active);
        self::assertEquals("2015-04-23T07:40:03Z", $zone->createdAt);
        self::assertEquals("2015-04-23T07:40:03Z", $zone->updatedAt);
    }

    public function testGetZoneFile()
    {
        $this->mockResponseWith("getZoneFile/success");
        $zoneFile = $this->service->getZoneFile(1010, "example-alpha.com")->getData();

        self::assertEquals("\$ORIGIN example.com.\n\$TTL 1h\nexample.com. 3600 IN SOA ns1.dnsimple.com. admin.dnsimple.com. 1453132552 86400 7200 604800 300\nexample.com. 3600 IN NS ns1.dnsimple.com.\nexample.com. 3600 IN NS ns2.dnsimple.com.\nexample.com. 3600 IN NS ns3.dnsimple.com.\nexample.com. 3600 IN NS ns4.dnsimple.com.\n", $zoneFile->zone);
    }

    public function testCheckZoneDistribution()
    {
        $this->mockResponseWith("checkZoneDistribution/success");
        $zoneDistribution = $this->service->checkZoneDistribution(1010, "example-alpha.com")->getData();

        self::assertTrue($zoneDistribution->distributed);
    }

    public function testCheckZoneDistributionFailure()
    {
        $this->mockResponseWith("checkZoneDistribution/failure");
        $zoneDistribution = $this->service->checkZoneDistribution(1010, "example-alpha.com")->getData();

        self::assertFalse($zoneDistribution->distributed);
    }

    public function testCheckZoneDistributionError()
    {
        $this->mockResponseWith("checkZoneDistribution/error");

        self::expectException(DnsimpleException::class);
        self::expectExceptionMessage("Could not query zone, connection timed out");

        $this->service->checkZoneDistribution(1010, "example.com");
    }

    public function testActivateZoneService()
    {
        $this->mockResponseWith("activateZoneService/success");

        $zone = $this->service->activateZoneService(1010, "example-alpha.com")->getData();

        self::assertEquals(1, $zone->id);
        self::assertEquals(1010, $zone->accountId);
        self::assertEquals("example.com", $zone->name);
        self::assertTrue($zone->active);
    }

    public function testDeactivateZoneService()
    {
        $this->mockResponseWith("deactivateZoneService/success");

        $zone = $this->service->deactivateZoneService(1010, "example-alpha.com")->getData();

        self::assertEquals(1, $zone->id);
        self::assertEquals(1010, $zone->accountId);
        self::assertEquals("example.com", $zone->name);
        self::assertFalse($zone->active);
    }
}
