<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Exceptions\BadRequestException;
use Dnsimple\Struct\WhoisPrivacy;

class RegistrarWhoisPrivacyTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testGetWhoisPrivacy()
    {
        $this->mockResponseWith("getWhoisPrivacy/success");
        $whoisPrivacy = $this->service->getWhoisPrivacy(1010, "example.com")->getData();

        self::assertInstanceOf(WhoisPrivacy::class, $whoisPrivacy);
        self::assertEquals(1, $whoisPrivacy->id);
        self::assertEquals(2, $whoisPrivacy->domainId);
        self::assertEquals("2017-02-13", $whoisPrivacy->expiresOn);
        self::assertTrue($whoisPrivacy->enabled);
        self::assertEquals("2016-02-13T14:34:50Z", $whoisPrivacy->createdAt);
        self::assertEquals("2016-02-13T14:34:52Z", $whoisPrivacy->updatedAt);
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

    public function testRenewWhoisPrivacy()
    {
        $this->mockResponseWith("renewWhoisPrivacy/success");
        $response = $this->service->renewWhoisPrivacy(1010, "example.com");
        $whoisPrivacy = $response->getData();

        self::assertEquals(201, $response->getStatusCode());
        self::assertInstanceOf(WhoisPrivacy::class, $whoisPrivacy);
    }

    public function testRenewWhoisPrivacyDuplicatedOrder()
    {
        $this->mockResponseWith("renewWhoisPrivacy/whois-privacy-duplicated-order");
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("The whois privacy for example.com has just been renewed, a new renewal cannot be started at this time");

        $this->service->renewWhoisPrivacy(1010, "example.com");
    }

    public function testRenewWhoisPrivacyNotFound()
    {
        $this->mockResponseWith("renewWhoisPrivacy/whois-privacy-not-found");
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("WHOIS privacy not found for example.com");

        $this->service->renewWhoisPrivacy(1010, "example.com");
    }
}
