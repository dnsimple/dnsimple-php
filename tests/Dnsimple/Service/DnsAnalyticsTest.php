<?php

namespace Dnsimple\Service;

use Dnsimple\DnsAnalyticsResponse;
use Dnsimple\Struct\DnsAnalytics as DnsAnalyticsRecord;
use Dnsimple\Struct\DnsAnalyticsQuery;

class DnsAnalyticsTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DnsAnalytics($this->client);
    }

    public function testQuery()
    {
        $this->mockResponseWith("dnsAnalytics/success");

        $response = $this->service->query(1010);
        self::assertInstanceOf(DnsAnalyticsResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $request = $this->mockHandler->getLastRequest();
        self::assertEquals("GET", $request->getMethod());
        self::assertEquals("/v2/1010/dns_analytics", $request->getUri()->getPath());
    }

    public function testQueryReturnsRecords()
    {
        $this->mockResponseWith("dnsAnalytics/success");

        $data = $this->service->query(1010)->getData();
        self::assertCount(12, $data);

        $record = $data[0];
        self::assertInstanceOf(DnsAnalyticsRecord::class, $record);
        self::assertEquals("bar.com", $record->zoneName);
        self::assertEquals("2023-12-08", $record->date);
        self::assertEquals(1200, $record->volume);

        $record = $data[4];
        self::assertEquals("example.com", $record->zoneName);
        self::assertEquals("2023-12-08", $record->date);
        self::assertEquals(1200, $record->volume);
    }

    public function testQueryHasPaginationObject()
    {
        $this->mockResponseWith("dnsAnalytics/success");

        $pagination = $this->service->query(1010)->getPagination();

        self::assertEquals(0, $pagination->currentPage);
        self::assertEquals(100, $pagination->perPage);
        self::assertEquals(93, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testQueryHasQueryObject()
    {
        $this->mockResponseWith("dnsAnalytics/success");

        $query = $this->service->query(1010)->getQuery();

        self::assertInstanceOf(DnsAnalyticsQuery::class, $query);
        self::assertEquals(1, $query->accountId);
        self::assertEquals("2023-12-08", $query->startDate);
        self::assertEquals("2024-01-08", $query->endDate);
        self::assertEquals("zone_name:asc,date:asc", $query->sort);
        self::assertEquals(0, $query->page);
        self::assertEquals(100, $query->perPage);
        self::assertEquals("zone_name,date", $query->groupings);
    }

    public function testQuerySupportsFilters()
    {
        $this->mockResponseWith("dnsAnalytics/success");
        $this->service->query(1010, ["start_date" => "2023-12-08", "end_date" => "2024-01-08"]);

        self::assertEquals("start_date=2023-12-08&end_date=2024-01-08", $this->queryContent());
    }

    public function testQuerySupportsGroupings()
    {
        $this->mockResponseWith("dnsAnalytics/success");
        $this->service->query(1010, ["groupings" => "zone_name,date"]);

        self::assertEquals("groupings=zone_name%2Cdate", $this->queryContent());
    }

    public function testQuerySupportsSorting()
    {
        $this->mockResponseWith("dnsAnalytics/success");
        $this->service->query(1010, ["sort" => "volume:desc,zone_name:asc"]);

        self::assertEquals("sort=volume%3Adesc%2Czone_name%3Aasc", $this->queryContent());
    }

    public function testQuerySupportsPagination()
    {
        $this->mockResponseWith("dnsAnalytics/success");
        $this->service->query(1010, ["page" => 2, "per_page" => 10]);

        self::assertEquals("page=2&per_page=10", $this->queryContent());
    }
}
