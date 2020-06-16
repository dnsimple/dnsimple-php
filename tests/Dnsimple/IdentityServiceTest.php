<?php

namespace Dnsimple;

final class IdentityServiceTest extends ServiceTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->service = new IdentityService($this->client);
    }

    /**
     * @group live
     */
    public function testWhoami_ForReal()
    {
        $this->client = new Client(getenv('DNSIMPLE_ACCESS_TOKEN'));
        $service = new IdentityService($this->client);
        $data = $service->whoami();

        print_r($data);
    }

    public function testWhoami()
    {
        $this->mockResponse("whoami/success.http");

        $resp = $this->service->whoami();
        $this->assertInstanceOf(Response::class, $resp);
        $this->assertEquals(200, $resp->getStatusCode());

        $data = $resp->getData();
        $this->assertInstanceOf("stdClass", $data);
        $this->assertObjectHasAttribute("user", $data);
        $this->assertObjectHasAttribute("account", $data);
    }
}
