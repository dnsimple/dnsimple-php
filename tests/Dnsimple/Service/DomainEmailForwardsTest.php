<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\EmailForward;

class DomainEmailForwardsTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DomainsService($this->client);
    }

    public function testListDomainEmailForwards()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $response = $this->service->listEmailForwards(1010, 1);

        $data = $response->getData();
        $this->assertCount(2, $data);

        $record = $data[0];
        $this->assertInstanceOf(EmailForward::class, $record);
    }

    public function testListDomainEmailForwardsSupportsSorting()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $this->service->listEmailForwards(1010, 1, ["sort" => "id:asc,from:desc,to:asc"]);

        $this->assertEquals("sort=id%3Aasc%2Cfrom%3Adesc%2Cto%3Aasc", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListDomainsEmailForwardsHasPaginationObject()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $response = $this->service->listEmailForwards(1010, 1);
        $pagination = $response->getPagination();

        $this->assertEquals(1, $pagination->currentPage);
        $this->assertEquals(30, $pagination->perPage);
        $this->assertEquals(2, $pagination->totalEntries);
        $this->assertEquals(1, $pagination->totalPages);
    }

    public function testListDomainEmailForwardsSupportsPagination()
    {
        $this->mockResponseWith("listEmailForwards/success");
        $this->service->listEmailForwards(1010, 1, ['page' => 1, 'per_page' => 4]);

        $this->assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testCreateEmailForward()
    {
        $this->mockResponseWith("createEmailForward/created");
        $attributes = [
            "from" => "jim@a-domain.com",
            "to" => "jikm@another.com"
        ];
        $response = $this->service->createEmailForward(1010, 228963, $attributes);


        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $data = $response->getData();
        $this->assertInstanceOf(EmailForward::class, $data);
    }

    public function testGetEmailForward()
    {
        $this->mockResponseWith("getEmailForward/success");
        $emailForward = $this->service->getEmailForward(1010, 228963, 17706)->getData();

        $this->assertEquals(17706, $emailForward->id);
        $this->assertEquals(228963, $emailForward->domainId);
        $this->assertEquals("jim@a-domain.com", $emailForward->from);
        $this->assertEquals("jim@another.com", $emailForward->to);
        $this->assertEquals("2016-02-04T14:26:50Z", $emailForward->createdAt);
        $this->assertEquals("2016-02-04T14:26:50Z", $emailForward->updatedAt);
    }

    public function testDeleteEmailForward()
    {
        $this->mockResponseWith("deleteEmailForward/success");

        $response = $this->service->deleteEmailForward(1010, 228963, 17706);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

}
