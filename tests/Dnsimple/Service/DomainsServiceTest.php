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
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(2, $data);

        $domain = $data[0];
        self::assertInstanceOf(Domain::class, $domain);
        self::assertEquals(181984, $domain->id);
    }

    public function testListDomainsSupportsFilters()
    {
        $this->mockResponseWith("listDomains/success");
        $this->service->listDomains(1, ["name_like"=>"example.com", "registrant_id"=>42]);

        self::assertEquals("name_like=example.com&registrant_id=42", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListDomainsSupportsSorting()
    {
        $this->mockResponseWith("listDomains/success");
        $this->service->listDomains(1, ["sort" => "id:asc,name:desc,expiration:asc"]);

        self::assertEquals("sort=id%3Aasc%2Cname%3Adesc%2Cexpiration%3Aasc", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testListDomainsHasPaginationObject()
    {
        $this->mockResponseWith("listDomains/success");
        $response = $this->service->listDomains(1);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListDomainsSupportsPagination()
    {
        $this->mockResponseWith("listDomains/success");
        $this->service->listDomains(1, ["page" => 1, "per_page" => 4]);

        self::assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testCreateDomain()
    {
        $this->mockResponseWith("createDomain/created") ;

        $attributes = [
            "name" => "example.com",
        ];

        $response = $this->service->createDomain(1, $attributes);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(201, $response->getStatusCode());

        $data = $response->getData();
        self::assertInstanceOf(Domain::class, $data);
        self::assertEquals(181985, $data->id);
        self::assertEquals(1385, $data->accountId);
        self::assertNull($data->registrantId);
    }

    public function testGetDomain()
    {
        $this->mockResponseWith("getDomain/success");

        $response = $this->service->getDomain(1, "example.com");
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertInstanceOf(Domain::class, $data);
        self::assertEquals(181984, $data->id);
        self::assertEquals(1385, $data->accountId);
        self::assertEquals(2715, $data->registrantId);
    }

    public function testDeleteDomain()
    {
        $this->mockResponseWith("deleteDomain/success");

        $response = $this->service->deleteDomain(1, "example.com");
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(204, $response->getStatusCode());
    }
}
