<?php
namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\DomainResearchStatus;

class DomainsResearchTest extends ServiceTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->service = new Domains($this->client);
    }

    public function testDomainResearchStatus()
    {
        $this->mockResponseWith("getDomainsResearchStatus/success-unavailable.http");

        $response = $this->service->domainResearchStatus(1010, "taken.com");
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertInstanceOf(DomainResearchStatus::class, $data);
        self::assertEquals("25dd77cb-2f71-48b9-b6be-1dacd2881418", $data->request_id);
        self::assertEquals("taken.com", $data->domain);
        self::assertEquals("unavailable", $data->availability);
        self::assertEquals([], $data->errors);

        $request = $this->mockHandler->getLastRequest();
        self::assertEquals("domain=taken.com", $request->getUri()->getQuery());
    }
}
