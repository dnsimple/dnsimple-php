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
        $this->mockResponseWith("domainResearchStatus/success");

        $response = $this->service->domainResearchStatus(1010, "example.com");
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertInstanceOf(DomainResearchStatus::class, $data);
        self::assertEquals("f453dabc-a27e-4bf1-a93e-f263577ffaae", $data->request_id);
        self::assertEquals("example.com", $data->domain);
        self::assertEquals("unavailable", $data->availability);
        self::assertEquals([], $data->errors);

        $request = $this->mockHandler->getLastRequest();
        self::assertEquals("domain=example.com", $request->getUri()->getQuery());
    }
}
