<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Service;

class ServicesDomainsTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Services($this->client);
    }

    public function testAppliedServices()
    {
        $this->mockResponseWith("appliedServices/success");

        $response = $this->service->appliedServices(1010, "example.com");
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(1, $data);

        $service = $data[0];
        self::assertInstanceOf(Service::class, $service);
    }

    public function testAppliedServicesHasPaginationObject()
    {
        $this->mockResponseWith("appliedServices/success");

        $response = $this->service->appliedServices(1010, "example.com");
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(1, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testAppliedServicesSupportsPagination()
    {
        $this->mockResponseWith("appliedServices/success");

        $this->service->appliedServices(1010, "example.com", ["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testApplyService()
    {
        $this->mockResponseWith("applyService/success");

        $response = $this->service->applyService(1010, "example.com", 1);

        self::assertEquals(204, $response->getStatusCode());
    }

    public function testUnapplyService()
    {
        $this->mockResponseWith("unapplyService/success");

        $response = $this->service->unapplyService(1010, "example.com", 1);

        self::assertEquals(204, $response->getStatusCode());
    }
}
