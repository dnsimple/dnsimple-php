<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\EmailForward;

class DomainEmailForwardsTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Domains($this->client);
    }

    public function testListDomainEmailForwards()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $response = $this->service->listEmailForwards(1010, 1);

        $data = $response->getData();
        self::assertCount(1, $data);

        $record = $data[0];
        self::assertInstanceOf(EmailForward::class, $record);
        self::assertEquals(true, $record->active);
    }

    public function testListDomainEmailForwardsSupportsSorting()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $this->service->listEmailForwards(1010, 1, ["sort" => "id:asc,from:desc,to:asc"]);

        self::assertEquals("sort=id%3Aasc%2Cfrom%3Adesc%2Cto%3Aasc", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListDomainsEmailForwardsHasPaginationObject()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $response = $this->service->listEmailForwards(1010, 1);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(1, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListDomainEmailForwardsSupportsPagination()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $this->service->listEmailForwards(1010, 1, ["page" => 1, "per_page" => 4]);

        self::assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testCreateEmailForward()
    {
        $this->mockResponseWith("createEmailForward/created");
        $attributes = [
            "from" => "jim@a-domain.com",
            "to" => "jikm@another.com"
        ];
        $response = $this->service->createEmailForward(1010, 228963, $attributes);


        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(201, $response->getStatusCode());

        $data = $response->getData();
        self::assertInstanceOf(EmailForward::class, $data);
        self::assertEquals(true, $data->active);
    }

    public function testGetEmailForward()
    {
        $this->mockResponseWith("getEmailForward/success");
        $emailForward = $this->service->getEmailForward(1010, 228963, 41872)->getData();

        self::assertEquals(41872, $emailForward->id);
        self::assertEquals(235146, $emailForward->domainId);
        self::assertEquals("example@dnsimple.xyz", $emailForward->from);
        self::assertEquals("example@example.com", $emailForward->to);
        self::assertEquals(true, $emailForward->active);
        self::assertEquals("2021-01-25T13:54:40Z", $emailForward->createdAt);
        self::assertEquals("2021-01-25T13:54:40Z", $emailForward->updatedAt);
    }

    public function testDeleteEmailForward()
    {
        $this->mockResponseWith("deleteEmailForward/success");

        $response = $this->service->deleteEmailForward(1010, 228963, 17706);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(204, $response->getStatusCode());
    }

}
