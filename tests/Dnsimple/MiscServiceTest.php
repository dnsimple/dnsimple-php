<?php

class MiscServiceTest extends ServiceTestCase
{
    /**
     * @group forReal
     */
    public function testWhoamiForReal() {
        $this->client = new Dnsimple\Client(getenv('DNSIMPLE_ACCESS_TOKEN'));
        $service = new \Dnsimple\MiscService($this->client);
        $data = $service->whoami();

        print_r($data);
    }

    public function testWhoami_ReturnsResponse() {
        $this->mockHandler->append(
            ResponseFixture::newFromFile(__DIR__ . "/../fixtures/misc/whoami/success.http")
        );

        $data = $this->service->whoami();
        $this->assertInstanceOf("stdClass", $data);
        $this->assertObjectHasAttribute("user", $data);
        $this->assertObjectHasAttribute("account", $data);
    }
}
