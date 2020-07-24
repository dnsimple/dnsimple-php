<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Service;

class ServicesTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Services($this->client);
    }

    public function testListServices()
    {
        $this->mockResponseWith("listServices/success");

        $response = $this->service->listServices();
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(2, $data);

        $service = $data[0];
        self::assertInstanceOf(Service::class, $service);
    }

    public function testListServicesSupportsSorting()
    {
        $this->mockResponseWith("listServices/success");

        $this->service->listServices(["sort" => "id:asc,sid:desc"]);

        self::assertEquals("sort=id%3Aasc%2Csid%3Adesc", $this->queryContent());
    }

    public function testListServicesHasPaginationObject()
    {
        $this->mockResponseWith("listServices/success");

        $response = $this->service->listServices();
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListServicesSupportsPagination()
    {
        $this->mockResponseWith("listServices/success");

        $this->service->listServices(["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testGetService()
    {
        $this->mockResponseWith("getService/success");

        $service = $this->service->getService(1)->getData();

        self::assertEquals(1, $service->id);
        self::assertEquals("Service 1", $service->name);
        self::assertEquals("service1", $service->sid);
        self::assertEquals("First service example.", $service->description);
        self::assertNull($service->setupDescription);
        self::assertTrue($service->requiresSetup);
        self::assertNull($service->defaultSubdomain);
        self::assertEquals("2014-02-14T19:15:19Z", $service->createdAt);
        self::assertEquals("2016-03-04T09:23:27Z", $service->updatedAt);
        self::assertCount(1, $service->settings);

        $setting = $service->settings[0];

        self::assertEquals("username", $setting->name);
        self::assertEquals("Service 1 Account Username", $setting->label);
        self::assertEquals(".service1.com", $setting->append);
        self::assertEquals("Your Service 1 username is used to connect services to your account.", $setting->description);
        self::assertEquals("username", $setting->example);
        self::assertFalse($setting->password);
    }
}
