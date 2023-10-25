<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Exceptions\BadRequestException;
use Dnsimple\Exceptions\HttpException;
use Dnsimple\Struct\Charge;
use Dnsimple\Struct\ChargeItem;

class BillingTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Billing($this->client);
    }

    public function testListCharges()
    {
        $this->mockResponseWith("listCharges/success");

        $response = $this->service->listCharges(1010);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(3, $data);

        $charge = $data[0];
        self::assertInstanceOf(Charge::class, $charge);
        self::assertEqualsWithDelta(14.5, $charge->totalAmount, 0.01);
        self::assertEquals("collected", $charge->state);

        $item = $charge->items[0];
        self::assertInstanceOf(ChargeItem::class, $item);
        self::assertEqualsWithDelta(14.5, $item->amount, 0.01);
        self::assertEquals("Register bubble-registered.com", $item->description);
    }

    public function testListChargesSupportsFilters()
    {
        $this->mockResponseWith("listCharges/success");
        $this->service->listCharges(1010, ["start_date"=>"2023-01-01", "end_date"=>"2023-08-31"]);

        self::assertEquals("start_date=2023-01-01&end_date=2023-08-31", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListChargesSupportsSorting()
    {
        $this->mockResponseWith("listCharges/success");
        $this->service->listCharges(1010, ["sort" => "invoiced:asc"]);

        self::assertEquals("sort=invoiced%3Aasc", $this->queryContent());
    }


    public function testListChargesHasPaginationObject()
    {
        $this->mockResponseWith("listCharges/success");
        $response = $this->service->listCharges(1010);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(3, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListChargesSupportsPagination()
    {
        $this->mockResponseWith("listCharges/success");
        $this->service->listCharges(1010, ["page" => 1, "per_page" => 4]);

        self::assertEquals("page=1&per_page=4", $this->queryContent());
    }

    public function testListChargesBadFilter()
    {
        $this->mockResponseWith("listCharges/fail-400-bad-filter");
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("Invalid date format must be ISO8601 (YYYY-MM-DD)");

        $this->service->listCharges(1010, ["start_date"=>"01-01-2023", "end_date"=>"08-31-2023"]);
    }

    public function testListChargesUnauthorized()
    {
        $this->mockResponseWith("listCharges/fail-403");
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage("Permission Denied. Required Scope: billing:*:read");

        $this->service->listCharges(1010);
    }

}
