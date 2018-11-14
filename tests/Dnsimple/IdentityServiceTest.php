<?php

final class IdentityServiceTest extends ServiceTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->service = new Dnsimple\IdentityService($this->client);
    }

    /**
     * @group live
     */
    public function testWhoami_ForReal()
    {
        $this->client = new Dnsimple\Client(getenv('DNSIMPLE_ACCESS_TOKEN'));
        $service = new \Dnsimple\IdentityService($this->client);
        $data = $service->whoami();

        print_r($data);
    }

    public function testWhoami()
    {
        $this->mockHandler->append(
            GuzzleHttp\Psr7\parse_response(file_get_contents(__DIR__ . "/../fixtures.http/api/whoami/success.http"))
        );

        $resp = $this->service->whoami();
        $this->assertInstanceOf(\Dnsimple\Response::class, $resp);

        $data = $resp->getData();
        $this->assertInstanceOf("stdClass", $data);
        $this->assertObjectHasAttribute("user", $data);
        $this->assertObjectHasAttribute("account", $data);
    }
}
