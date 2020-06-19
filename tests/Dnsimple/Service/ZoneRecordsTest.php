<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\ZoneRecord;

class ZoneRecordsTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ZonesService($this->client);
    }

    public function testListRecords()
    {
        $this->mockResponseWith("listZoneRecords/success");

        $response = $this->service->listRecords(1010, "example.com");
        self::assertInstanceOf(Response::class, $response);

        $data = $response->getData();
        self::assertCount(5, $data);

        $zoneRecord = $data[0];
        self::assertInstanceOf(ZoneRecord::class, $zoneRecord);
        self::assertEquals(1, $zoneRecord->id);
    }

    public function testListRecordsSupportsFilters()
    {
        $this->mockResponseWith("listZoneRecords/success");
        $this->service->listRecords(1010, "example.com", ["name_like" => "example"]);

        self::assertEquals("name_like=example", $this->queryContent());
    }

    public function testListRecordsSupportsSorting()
    {
        $this->mockResponseWith("listZoneRecords/success");
        $this->service->listRecords(1010, "example.com", ["sort" => "id:desc"]);

        self::assertEquals("sort=id%3Adesc", $this->queryContent());
    }

    public function testListRecordsHasPaginationObject()
    {
        $this->mockResponseWith("listZoneRecords/success");
        $pagination = $this->service->listRecords(1010, "example.com")->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(5, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListRecordsSupportsPagination()
    {
        $this->mockResponseWith("listZoneRecords/success");
        $this->service->listRecords(1010, "example.com", ["page" => 1, "per_page" => 5]);

        self::assertEquals("page=1&per_page=5", $this->queryContent());
    }

    public function testCreateZoneRecord()
    {
        $this->mockResponseWith("createZoneRecord/created");

        $attributes = [
            "name" => "www",
            "type" => "MX",
            "content" => "mxa.example.com",
            "ttl" => 600,
            "priority" => 10,
            "regions" => ["SV1", "IAD"]
        ];

        $response = $this->service->createRecord(1010, "example.com", $attributes);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(201, $response->getStatusCode());

        $record = $response->getData();
        self::assertInstanceOf(ZoneRecord::class, $record);
        self::assertEquals(1, $record->id);
        self::assertEquals("www", $record->name);
    }

    public function testCreateApexZoneRecord()
    {
        $this->mockResponseWith("createZoneRecord/created-apex");

        $attributes = [
            "name" => "",
            "type" => "MX",
            "content" => "mxa.example.com",
            "ttl" => 600,
            "priority" => 10,
            "regions" => ["SV1", "IAD"]
        ];

        $record = $this->service->createRecord(1010, "example.com", $attributes)->getData();

        self::assertEquals("", $record->name);
    }

    public function testGetZoneRecord()
    {
        $this->mockResponseWith("getZoneRecord/success");
        $record = $this->service->getRecord(1010, "example.com", 5)->getData();

        self::assertEquals(5, $record->id);
        self::assertEquals("example.com", $record->zoneId);
        self::assertNull($record->parentId);
        self::assertEmpty($record->name);
        self::assertEquals("mxa.example.com", $record->content);
        self::assertEquals(600, $record->ttl);
        self::assertEquals(10, $record->priority);
        self::assertEquals("MX", $record->type);
        self::assertEquals(["SV1", "IAD"], $record->regions);
        self::assertFalse($record->systemRecord);
        self::assertEquals("2016-10-05T09:51:35Z", $record->createdAt);
        self::assertEquals("2016-10-05T09:51:35Z", $record->updatedAt);
    }

    public function testUpdateZoneRecord()
    {
        $this->mockResponseWith("updateZoneRecord/success");
        $attributes = [
            "content" => "mxb.example.com",
            "ttl" => 3600,
            "priority" => 20,
            "regions" => ["global"]
        ];
        $response = $this->service->updateRecord(1010, "example.com", 5, $attributes);
        self::assertEquals(200, $response->getStatusCode());

        $record = $response->getData();
        self::assertEquals("mxb.example.com", $record->content);
        self::assertEquals(3600, $record->ttl);
        self::assertEquals(20, $record->priority);
        self::assertEquals(["global"], $record->regions);
    }

    public function testDeleteZoneRecord()
    {
        $this->mockResponseWith("deleteZoneRecord/success");
        $response = $this->service->deleteRecord(1010, "example.com", 5);

        self::assertEquals(204, $response->getStatusCode());
    }

    public function testCheckZoneRecordDistribution()
    {
        $this->mockResponseWith("checkZoneRecordDistribution/success");
        $distribution = $this->service->checkZoneRecordDistribution(1010, "example.com", 5)->getData();

        self::assertTrue($distribution->distributed);
    }

    public function testCheckZoneRecordDistributionFailure()
    {
        $this->mockResponseWith("checkZoneRecordDistribution/failure");
        $distribution = $this->service->checkZoneRecordDistribution(1010, "example.com", 5)->getData();

        self::assertFalse($distribution->distributed);
    }

    public function testCheckZoneDistributionError()
    {
        $this->mockResponseWith("checkZoneRecordDistribution/error");

        $this->expectException(DnsimpleException::class);
        $this->expectExceptionMessage("Could not query zone, connection timed out");

        $this->service->checkZoneRecordDistribution(1010, "example.com", 5);

    }


}
