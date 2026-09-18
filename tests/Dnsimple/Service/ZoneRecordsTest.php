<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Exceptions\BadRequestException;
use Dnsimple\Response;
use Dnsimple\Struct\ZoneRecord;
use Dnsimple\Struct\ZoneRecordId;
use Dnsimple\Struct\ZoneRecordsBatchChange;

class ZoneRecordsTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Zones($this->client);
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

    public function testBatchChangeZoneRecords()
    {
        $this->mockResponseWith("batchChangeZoneRecords/success");

        $attributes = [
            "creates" => [
                ["type" => "A", "content" => "3.2.3.4", "name" => "ab"],
                ["type" => "A", "content" => "4.2.3.4", "name" => "ab"]
            ],
            "updates" => [
                ["id" => 67622534, "content" => "3.2.3.40"],
                ["id" => 67622537, "content" => "5.2.3.40"]
            ],
            "deletes" => [
                ["id" => 67622509],
                ["id" => 67622527]
            ]
        ];
        $response = $this->service->batchChangeZoneRecords(1010, "example.com", $attributes);

        $request = $this->mockHandler->getLastRequest();
        self::assertEquals("POST", $request->getMethod());
        self::assertEquals("/v2/1010/zones/example.com/batch", $request->getUri()->getPath());
        self::assertEquals($attributes, json_decode((string) $request->getBody(), true));

        self::assertEquals(200, $response->getStatusCode());
        $batch = $response->getData();
        self::assertInstanceOf(ZoneRecordsBatchChange::class, $batch);

        self::assertCount(2, $batch->creates);
        self::assertInstanceOf(ZoneRecord::class, $batch->creates[0]);
        self::assertEquals(67623409, $batch->creates[0]->id);
        self::assertEquals("example.com", $batch->creates[0]->zoneId);
        self::assertEquals("ab", $batch->creates[0]->name);
        self::assertEquals("3.2.3.4", $batch->creates[0]->content);
        self::assertEquals(3600, $batch->creates[0]->ttl);
        self::assertEquals("A", $batch->creates[0]->type);
        self::assertEquals(["global"], $batch->creates[0]->regions);
        self::assertEquals(67623410, $batch->creates[1]->id);
        self::assertEquals("4.2.3.4", $batch->creates[1]->content);

        self::assertCount(2, $batch->updates);
        self::assertInstanceOf(ZoneRecord::class, $batch->updates[0]);
        self::assertEquals(67622534, $batch->updates[0]->id);
        self::assertEquals("update1-1757049890", $batch->updates[0]->name);
        self::assertEquals("3.2.3.40", $batch->updates[0]->content);
        self::assertEquals(67622537, $batch->updates[1]->id);
        self::assertEquals("5.2.3.40", $batch->updates[1]->content);

        self::assertCount(2, $batch->deletes);
        self::assertInstanceOf(ZoneRecordId::class, $batch->deletes[0]);
        self::assertEquals(67622509, $batch->deletes[0]->id);
        self::assertEquals(67622527, $batch->deletes[1]->id);
    }

    public function testBatchChangeZoneRecordsCreateValidationFailed()
    {
        $this->mockResponseWith("batchChangeZoneRecords/error_400_create_validation_failed");

        try {
            $this->service->batchChangeZoneRecords(1010, "example.com", [
                "creates" => [["type" => "SPF", "content" => "v=spf1 -all", "name" => "ab"]]
            ]);
            self::fail("Expected BadRequestException");
        } catch (BadRequestException $e) {
            self::assertEquals("Validation failed", $e->getMessage());
            $errors = $e->getAttributeErrors();
            self::assertArrayHasKey("creates", $errors);
            self::assertEquals(0, $errors["creates"][0]->index);
            self::assertEquals(["unsupported"], $errors["creates"][0]->errors->record_type);
        }
    }

    public function testBatchChangeZoneRecordsUpdateValidationFailed()
    {
        $this->mockResponseWith("batchChangeZoneRecords/error_400_update_validation_failed");

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("Validation failed");

        $this->service->batchChangeZoneRecords(1010, "example.com", [
            "updates" => [["id" => 99999999, "content" => "1.2.3.4"]]
        ]);
    }

    public function testBatchChangeZoneRecordsDeleteValidationFailed()
    {
        $this->mockResponseWith("batchChangeZoneRecords/error_400_delete_validation_failed");

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("Validation failed");

        $this->service->batchChangeZoneRecords(1010, "example.com", [
            "deletes" => [["id" => 67622509]]
        ]);
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
