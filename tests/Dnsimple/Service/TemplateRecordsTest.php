<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\TemplateRecord;

class TemplateRecordsTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Templates($this->client);
    }

    public function testListTemplateRecords()
    {
        $this->mockResponseWith("listTemplateRecords/success");

        $response = $this->service->listTemplateRecords(1010, 1);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(2, $data);

        $record = $data[0];
        self::assertInstanceOf(TemplateRecord::class, $record);
    }

    public function testListTemplateRecordsSupportsSorting()
    {
        $this->mockResponseWith("listTemplateRecords/success");

        $this->service->listTemplateRecords(1010, 1, ["sort" => "id:asc,name:desc,content:asc,type:desc"]);

        self::assertEquals("sort=id%3Aasc%2Cname%3Adesc%2Ccontent%3Aasc%2Ctype%3Adesc", $this->queryContent());

    }

    public function testListTemplateRecordsHasPaginationObject()
    {
        $this->mockResponseWith("listTemplateRecords/success");

        $response = $this->service->listTemplateRecords(1010, 1);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListTemplateRecordsSupportsPagination()
    {
        $this->mockResponseWith("listTemplateRecords/success");

        $this->service->listTemplateRecords(1010, 1, ["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testCreateTemplateRecord()
    {
        $this->mockResponseWith("createTemplateRecord/created");

        $attributes = [
            "name" => "",
            "type" => "MX",
            "content" => "mx.example.com",
            "ttl" => 600,
            "priority" => 10
        ];
        $record = $this->service->createTemplateRecord(1010, 1, $attributes)->getData();

        self::assertInstanceOf(TemplateRecord::class, $record);
    }

    public function testGetTemplateRecord()
    {
        $this->mockResponseWith("getTemplateRecord/success");

        $record = $this->service->getTemplateRecord(1010, 268, 301)->getData();

        self::assertEquals(301, $record->id);
        self::assertEquals(268, $record->templateId);
        self::assertEquals("", $record->name);
        self::assertEquals("mx.example.com", $record->content);
        self::assertEquals(600, $record->ttl);
        self::assertEquals(10, $record->priority);
        self::assertEquals("MX", $record->type);
        self::assertEquals("2016-05-03T08:03:26Z", $record->createdAt);
        self::assertEquals("2016-05-03T08:03:26Z", $record->updatedAt);
    }

    public function testDeleteTemplateRecord()
    {
        $this->mockResponseWith("deleteTemplateRecord/success");

        $response = $this->service->deleteTemplateRecord(1010, 268, 301);

        self::assertEquals(204, $response->getStatusCode());
    }
}
