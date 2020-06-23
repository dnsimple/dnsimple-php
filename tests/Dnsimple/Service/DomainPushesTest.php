<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\DomainPush;

class DomainPushesTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Domains($this->client);
    }

    public function testInitiatePush()
    {
        $this->mockResponseWith("initiatePush/success");
        $attributes = [
            "new_account_email" => "admin@target-account.test"
        ];
        $push = $this->service->initiatePush(2020, 100, $attributes)->getData();

        self::assertEquals(1, $push->id);
        self::assertEquals(100, $push->domainId);
        self::assertNull($push->contactId);
        self::assertEquals(2020, $push->accountId);
        self::assertEquals("2016-08-11T10:16:03Z", $push->createdAt);
        self::assertEquals("2016-08-11T10:16:03Z", $push->updatedAt);
        self::assertNull($push->acceptedAt);
    }

    public function testListPushes()
    {
        $this->mockResponseWith("listPushes/success");
        $response = $this->service->listPushes(2020);

        $data = $response->getData();
        self::assertCount(2, $data);

        $record = $data[0];
        self::assertInstanceOf(DomainPush::class, $record);
    }

    public function testListPushesHasPagination() {
        $this->mockResponseWith("listPushes/success");
        $response = $this->service->listPushes(2020);

        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListPushesSupportsPagination()
    {
        $this->mockResponseWith("listPushes/success");
        $this->service->listPushes(2020, ["page" => 1, "per_page" => 4]);

        self::assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testAcceptPush()
    {
        $this->mockResponseWith("acceptPush/success");
        $attributes = [
            "contact_id" => 42
        ];
        $response = $this->service->acceptPush(2020, 1, $attributes);

        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(204, $response->getStatusCode());
    }

    public function testRejectPush()
    {
        $this->mockResponseWith("rejectPush/success");
        $response = $this->service->rejectPush(2020, 1);

        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(204, $response->getStatusCode());
    }
}
