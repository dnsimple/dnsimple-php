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
        self::assertCount(2, $data);

        $record = $data[0];
        self::assertInstanceOf(EmailForward::class, $record);
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
        self::assertEquals(2, $pagination->totalEntries);
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
    }

    public function testGetEmailForward()
    {
        $this->mockResponseWith("getEmailForward/success");
        $emailForward = $this->service->getEmailForward(1010, 228963, 17706)->getData();

        self::assertEquals(17706, $emailForward->id);
        self::assertEquals(228963, $emailForward->domainId);
        self::assertEquals("jim@a-domain.com", $emailForward->from);
        self::assertEquals("jim@another.com", $emailForward->to);
        self::assertEquals("2016-02-04T14:26:50Z", $emailForward->createdAt);
        self::assertEquals("2016-02-04T14:26:50Z", $emailForward->updatedAt);
    }

    public function testDeleteEmailForward()
    {
        $this->mockResponseWith("deleteEmailForward/success");

        $response = $this->service->deleteEmailForward(1010, 228963, 17706);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(204, $response->getStatusCode());
    }

}
