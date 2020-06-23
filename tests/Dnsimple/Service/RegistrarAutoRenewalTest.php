<?php

namespace Dnsimple\Service;

class RegistrarAutoRenewalTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testEnableDomainAutoRenewal()
    {
        $this->mockResponseWith("enableDomainAutoRenewal/success");
        $response = $this->service->enableDomainAutoRenewal(1010, "example.com");

        self::assertEquals(204, $response->getStatusCode());
    }


    public function testDisableDomainAutoRenewal()
    {
        $this->mockResponseWith("disableDomainAutoRenewal/success");
        $response = $this->service->disableDomainAutoRenewal(1010, "example.com");

        self::assertEquals(204, $response->getStatusCode());
    }
}
