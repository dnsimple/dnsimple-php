<?php

namespace Dnsimple\Service;

use Dnsimple\Struct\WhoisPrivacy;

class RegistrarWhoisPrivacyTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testEnableWhoisPrivacy()
    {
        $this->mockResponseWith("enableWhoisPrivacy/success");
        $response = $this->service->enableWhoisPrivacy(1010, "example.com");
        $whoisPrivacy = $response->getData();

        self::assertEquals(200, $response->getStatusCode());
        self::assertInstanceOf(WhoisPrivacy::class, $whoisPrivacy);
    }

    public function testEnableAndPurchaseWhoisPrivacy()
    {
        $this->mockResponseWith("enableWhoisPrivacy/created");
        $response = $this->service->enableWhoisPrivacy(1010, "example.com");
        $whoisPrivacy = $response->getData();

        self::assertEquals(201, $response->getStatusCode());
        self::assertInstanceOf(WhoisPrivacy::class, $whoisPrivacy);
    }

    public function testDisableWhoisPrivacy()
    {
        $this->mockResponseWith("disableWhoisPrivacy/success");
        $response = $this->service->disableWhoisPrivacy(1010, "example.com");
        $whoisPrivacy = $response->getData();

        self::assertEquals(200, $response->getStatusCode());
        self::assertInstanceOf(WhoisPrivacy::class, $whoisPrivacy);
    }
}
