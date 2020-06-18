<?php
namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Domain;

class DomainsServiceTest extends ServiceTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->service = new DomainsService($this->client);
    }

    public function testListDomains()
    {
        $this->mockResponseWith("listDomains/success");

        $response = $this->service->listDomains(1);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        $this->assertCount(2, $data);

        $domain = $data[0];
        $this->assertInstanceOf(Domain::class, $domain);
        $this->assertEquals(181984, $domain->id);
    }

    public function testListDomainsSupportsFilters()
    {
        $this->mockResponseWith("listDomains/success");
        $this->service->listDomains(1, ["name_like"=>"example.com", "registrant_id"=>42]);

        $this->assertEquals("name_like=example.com&registrant_id=42", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListDomainsSupportsSorting()
    {
        $this->mockResponseWith("listDomains/success");
        $this->service->listDomains(1, ["sort" => "id:asc,name:desc,expiration:asc"]);

        $this->assertEquals("sort=id%3Aasc%2Cname%3Adesc%2Cexpiration%3Aasc", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListDomainsHasPaginationObject()
    {
        $this->mockResponseWith("listDomains/success");
        $response = $this->service->listDomains(1);
        $pagination = $response->getPagination();

        $this->assertEquals(1, $pagination->currentPage);
        $this->assertEquals(30, $pagination->perPage);
        $this->assertEquals(2, $pagination->totalEntries);
        $this->assertEquals(1, $pagination->totalPages);
    }

    public function testListDomainsSupportsPagination()
    {
        $this->mockResponseWith("listDomains/success");
        $this->service->listDomains(1, ['page' => 1, 'per_page' => 4]);

        $this->assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testCreateDomain()
    {
        $this->mockResponseWith("createDomain/created") ;

        $attributes = [
            "name" => "example.com",
        ];

        $response = $this->service->createDomain(1, $attributes);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $data = $response->getData();
        $this->assertInstanceOf(Domain::class, $data);
        $this->assertEquals(181985, $data->id);
        $this->assertEquals(1385, $data->accountId);
        $this->assertNull($data->registrantId);
    }

    public function testGetDomain()
    {
        $this->mockResponseWith("getDomain/success");

        $response = $this->service->getDomain(1, "example.com");
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        $this->assertInstanceOf(Domain::class, $data);
        $this->assertEquals(181984, $data->id);
        $this->assertEquals(1385, $data->accountId);
        $this->assertEquals(2715, $data->registrantId);
    }

    public function testDeleteDomain()
    {
        $this->mockResponseWith("deleteDomain/success");

        $response = $this->service->deleteDomain(1, "example.com");
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
