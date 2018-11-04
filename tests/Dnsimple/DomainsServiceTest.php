<?php

final class DomainsServiceTest extends ServiceTestCase
{
    protected function setUp() {
        parent::setUp();
        $this->service = new Dnsimple\DomainsService($this->client);
    }

    public function testGetDomain_ReturnsResponse() {
        $this->mockHandler->append(
            GuzzleHttp\Psr7\parse_response(file_get_contents(__DIR__ . "/../fixtures.http/getDomain/success.http"))
        );

        $data = $this->service->getDomain(1, "example.com");
        $this->assertInstanceOf("stdClass", $data);
        $this->assertEquals($data->id, 1);
        $this->assertEquals($data->account_id, 1010);
        $this->assertNull($data->registrant_id);
    }
}
