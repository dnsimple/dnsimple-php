<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\DelegationSignerRecord;

class DomainDelegationSignerRecordsTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DomainsService($this->client);
    }

    public function testListDomainDelegationSignerRecords()
    {
        $this->mockResponseWith("listDelegationSignerRecords/success");
        $response = $this->service->listDomainDelegationSignerRecords(1010, 1);

        $data = $response->getData();
        $this->assertCount(1, $data);

        $record = $data[0];
        $this->assertInstanceOf(DelegationSignerRecord::class, $record);
    }

    public function testListDomainDelegationSignerRecordsHasPaginationObject()
    {
        $this->mockResponseWith("listDelegationSignerRecords/success");
        $response = $this->service->listDomainDelegationSignerRecords(1010, 100);
        $pagination = $response->getPagination();

        $this->assertEquals(1, $pagination->currentPage);
        $this->assertEquals(30, $pagination->perPage);
        $this->assertEquals(1, $pagination->totalEntries);
        $this->assertEquals(1, $pagination->totalPages);
    }

    public function testListDomainDelegationSignerRecordsSupportsPagination()
    {
        $this->mockResponseWith("listDelegationSignerRecords/success");
        $this->service->listDomainDelegationSignerRecords(1010, 100, ["page" => 1, "per_page" => 4]);

        $this->assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListDomainDelegationsSignerRecordsSupportsSorting()
    {
        $this->mockResponseWith("listDelegationSignerRecords/success");
        $this->service->listDomains(1, ["sort" => "id:asc,created_at:desc"]);

        $this->assertEquals("sort=id%3Aasc%2Ccreated_at%3Adesc", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testCreateDomainDelegationSignerRecord()
    {
        $this->mockResponseWith("createDelegationSignerRecord/created");
        $attributes = [
            "algorithm" => 13,
            "digest" => "684a1f049d7d082b7f98691657da5a65764913df7f065f6f8c36edf62d66ca03",
            "digest_type" => 2,
            "keytag" => 2371
        ];

        $response = $this->service->createDomainDelegationSignerRecord(1010, 1, $attributes);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $data = $response->getData();
        $this->assertInstanceOf(DelegationSignerRecord::class, $data);
    }

    public function testCreateDomainDelegationSignerRecordFailsValidation()
    {
        $this->mockResponseWith("createDelegationSignerRecord/validation-error");

        $this->expectException(DnsimpleException::class);
        $this->service->createDomainDelegationSignerRecord(1010, 1, []);
    }

    public function testGetDomainDelegationSignerRecord()
    {
        $this->mockResponseWith("getDelegationSignerRecord/success");
        $record = $this->service->getDomainDelegationSignerRecord(1010, 1010, 24)->getData();

        $this->assertEquals(24, $record->id);
        $this->assertEquals(1010, $record->domainId);
        $this->assertEquals(8, $record->algorithm);
        $this->assertEquals("C1F6E04A5A61FBF65BF9DC8294C363CF11C89E802D926BDAB79C55D27BEFA94F", $record->digest);
        $this->assertEquals(2, $record->digestType);
        $this->assertEquals(44620, $record->keytag);
        $this->assertEquals("2017-03-03T13:49:58Z", $record->createdAt);
        $this->assertEquals("2017-03-03T13:49:58Z", $record->updatedAt);
    }

    public function testDeleteDomainDelegationSignerRecord()
    {
        $this->mockResponseWith("deleteDelegationSignerRecord/success");
        $response = $this->service->deleteDomainDelegationSignerRecord(1010, 1010, 24);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
