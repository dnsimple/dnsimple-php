<?php

namespace Dnsimple\ Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Zone;

class ZonesTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ZonesService($this->client);
    }

    public function testListZones()
    {
        $this->mockResponseWith("listZones/success");

        $response = $this->service->listZones(1010);
        $this->assertInstanceOf(Response::class, $response);

        $data = $response->getData();
        $this->assertCount(2, $data);

        $zone = $data[0];
        $this->assertInstanceOf(Zone::class, $zone);
        $this->assertEquals(1, $zone->id);
    }

    public function testListZonesSupportsFilters()
    {
        $this->mockResponseWith("listZones/success");
        $this->service->listZones(1010, ["name_like" => "example-alpha.com"]);

        $this->assertEquals("name_like=example-alpha.com", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListZonesSupportsSorting()
    {
        $this->mockResponseWith("listZones/success");
        $this->service->listZones(1010, ["sort" => "id:asc,name:desc"]);

        $this->assertEquals("sort=id%3Aasc%2Cname%3Adesc", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListZonesHasPaginationObject()
    {
        $this->mockResponseWith("listZones/success");
        $response = $this->service->listZones(1010);
        $pagination = $response->getPagination();

        $this->assertEquals(1, $pagination->currentPage);
        $this->assertEquals(30, $pagination->perPage);
        $this->assertEquals(2, $pagination->totalEntries);
        $this->assertEquals(1, $pagination->totalPages);
    }

    public function testListZonesSupportsPagination()
    {
        $this->mockResponseWith("listZones/success");
        $this->service->listZones(1010, ["page" => 1, "per_page" => 2]);

        $this->assertEquals("page=1&per_page=2", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testGetZone()
    {
        $this->mockResponseWith("getZone/success");
        $zone = $this->service->getZone(1010, "example-alpha.com")->getData();

        $this->assertEquals(1, $zone->id);
        $this->assertEquals(1010, $zone->accountId);
        $this->assertEquals("example-alpha.com", $zone->name);
        $this->assertFalse($zone->reverse);
        $this->assertEquals("2015-04-23T07:40:03Z", $zone->createdAt);
        $this->assertEquals("2015-04-23T07:40:03Z", $zone->updatedAt);
    }

    public function testGetZoneFile()
    {
        $this->mockResponseWith("getZoneFile/success");
        $zoneFile = $this->service->getZoneFile(1010, "example-alpha.com")->getData();

        $this->assertEquals("\$ORIGIN example.com.\n\$TTL 1h\nexample.com. 3600 IN SOA ns1.dnsimple.com. admin.dnsimple.com. 1453132552 86400 7200 604800 300\nexample.com. 3600 IN NS ns1.dnsimple.com.\nexample.com. 3600 IN NS ns2.dnsimple.com.\nexample.com. 3600 IN NS ns3.dnsimple.com.\nexample.com. 3600 IN NS ns4.dnsimple.com.\n", $zoneFile->zone);
    }

    public function testCheckZoneDistribution()
    {
        $this->mockResponseWith("checkZoneDistribution/success");
        $zoneDistribution = $this->service->checkZoneDistribution(1010, "example-alpha.com")->getData();

        $this->assertTrue($zoneDistribution->distributed);
    }

    public function testCheckZoneDistributionFailure()
    {
        $this->mockResponseWith("checkZoneDistribution/failure");
        $zoneDistribution = $this->service->checkZoneDistribution(1010, "example-alpha.com")->getData();

        $this->assertFalse($zoneDistribution->distributed);
    }

    public function testCheckZoneDistributionError()
    {
        $this->mockResponseWith("checkZoneDistribution/error");
        $this->expectException(DnsimpleException::class);
        $this->expectExceptionMessage("Could not query zone, connection timed out");
        $this->service->checkZoneDistribution(1010, "example.com");
    }
}
