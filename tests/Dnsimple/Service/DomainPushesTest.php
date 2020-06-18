<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\DomainPush;

class DomainPushesTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DomainsService($this->client);
    }

    public function testInitiatePush()
    {
        $this->mockResponseWith("initiatePush/success");
        $attributes = [
            "new_account_email" => "admin@target-account.test"
        ];
        $push = $this->service->initiatePush(2020, 100, $attributes)->getData();

        $this->assertEquals(1, $push->id);
        $this->assertEquals(100, $push->domainId);
        $this->assertNull($push->contactId);
        $this->assertEquals(2020, $push->accountId);
        $this->assertEquals("2016-08-11T10:16:03Z", $push->createdAt);
        $this->assertEquals("2016-08-11T10:16:03Z", $push->updatedAt);
        $this->assertNull($push->acceptedAt);
    }

    public function testListPushes()
    {
        $this->mockResponseWith("listPushes/success");
        $response = $this->service->listPushes(2020);

        $data = $response->getData();
        $this->assertCount(2, $data);

        $record = $data[0];
        $this->assertInstanceOf(DomainPush::class, $record);
    }

    public function testListPushesHasPagination() {
        $this->mockResponseWith("listPushes/success");
        $response = $this->service->listPushes(2020);

        $pagination = $response->getPagination();

        $this->assertEquals(1, $pagination->currentPage);
        $this->assertEquals(30, $pagination->perPage);
        $this->assertEquals(2, $pagination->totalEntries);
        $this->assertEquals(1, $pagination->totalPages);
    }

    public function testListPushesSupportsPagination()
    {
        $this->mockResponseWith("listPushes/success");
        $this->service->listPushes(2020, ['page' => 1, 'per_page' => 4]);

        $this->assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testAcceptPush()
    {
        $this->mockResponseWith("acceptPush/success");
        $attributes = [
            "contact_id" => 42
        ];
        $response = $this->service->acceptPush(2020, 1, $attributes);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testRejectPush()
    {
        $this->mockResponseWith("rejectPush/success");
        $response = $this->service->rejectPush(2020, 1);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
