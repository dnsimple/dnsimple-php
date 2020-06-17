<?php
namespace Dnsimple;

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

        $resp = $this->service->listDomains(1);
        $this->assertInstanceOf(Response::class, $resp);
        $this->assertEquals(200, $resp->getStatusCode());

        $data = $resp->getData();
        $this->assertCount(2, $data);

        $domain = $data[0];
        $this->assertInstanceOf("stdClass", $domain);
        $this->assertEquals(181984, $domain->id);
    }

    public function testCreateDomain()
    {
        $this->mockResponseWith("createDomain/created") ;

        $attrs = [
            "name" => "example.com",
        ];

        $resp = $this->service->createDomain(1, $attrs);
        $this->assertInstanceOf(Response::class, $resp);
        $this->assertEquals(201, $resp->getStatusCode());

        $data = $resp->getData();
        $this->assertInstanceOf("stdClass", $data);
        $this->assertEquals(181985, $data->id);
        $this->assertEquals(1385, $data->account_id);
        $this->assertNull($data->registrant_id);
    }

    public function testGetDomain()
    {
        $this->mockResponseWith("getDomain/success");

        $resp = $this->service->getDomain(1, "example.com");
        $this->assertInstanceOf(Response::class, $resp);
        $this->assertEquals(200, $resp->getStatusCode());

        $data = $resp->getData();
        $this->assertInstanceOf("stdClass", $data);
        $this->assertEquals(181984, $data->id);
        $this->assertEquals(1385, $data->account_id);
        $this->assertEquals(2715, $data->registrant_id);
    }

    public function testDeleteDomain()
    {
        $this->mockResponseWith("deleteDomain/success");

        $resp = $this->service->deleteDomain(1, "example.com");
        $this->assertInstanceOf(Response::class, $resp);
        $this->assertEquals(204, $resp->getStatusCode());
    }
}
