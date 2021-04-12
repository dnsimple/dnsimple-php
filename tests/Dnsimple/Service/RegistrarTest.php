<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Struct\DomainCheck;
use Dnsimple\Struct\DomainRenewal;
use Dnsimple\Struct\DomainTransfer;

class RegistrarTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testCheckDomain()
    {
        $this->mockResponseWith("checkDomain/success");
        $check = $this->service->checkDomain(1010, "ruby.codes")->getData();

        self::assertInstanceOf(DomainCheck::class, $check);
        self::assertEquals("ruby.codes", $check->domain);
        self::assertTrue($check->available);
        self::assertTrue($check->premium);
    }

    public function testGetDomainPremiumPrice()
    {
        $this->mockResponseWith("getDomainPremiumPrice/success");
        $premiumPrice = $this->service->getDomainPremiumPrice(1010, "ruby.codes", "registration")->getData();

        self::assertEquals("109.00", $premiumPrice->premiumPrice);
        self::assertEquals("registration", $premiumPrice->action);
    }


    public function testGetDomainPremiumPriceFailure()
    {
        $this->mockResponseWith("getDomainPremiumPrice/failure");
        $this->expectException(DnsimpleException::class);
        $this->expectExceptionMessage("`example.com` is not a premium domain for registration");

        $this->service->getDomainPremiumPrice(1010, "example.com");
    }

    public function testGetDomainPrices()
    {
      $this->mockResponseWith("getDomainPrices/success");
      $prices = $this->service->getDomainPrices(1010, "bingo.pizza")->getData();

      self::assertEquals("bingo.pizza", $prices->domain);
      self::assertEquals(true, $prices->premium);
      self::assertEquals(20.0, $prices->registrationPrice);
      self::assertEquals(20.0, $prices->renewalPrice);
      self::assertEquals(20.0, $prices->transferPrice);
    }

    public function testGetDomainPricesFailure()
    {
      $this->mockResponseWith("getDomainPrices/failure");
      $this->expectException(DnsimpleException::class);
      $this->expectExceptionMessage("TLD .PINEAPPLE is not supported");

      $this->service->getDomainPrices(1010, "bingo.pineapple");
    }

    public function testRegisterDomain()
    {
        $this->mockResponseWith("registerDomain/success");
        $attributes = [
            "registrant_id" => 2,
            "whois_privacy" => false,
            "auto_renew" => false
        ];

        $registration = $this->service->registerDomain(1010, "example.com", $attributes)->getData();

        self::assertEquals(1, $registration->id);
        self::assertEquals(999, $registration->domainId);
        self::assertEquals(2, $registration->registrantId);
        self::assertEquals(1, $registration->period);
        self::assertEquals("new", $registration->state);
        self::assertFalse($registration->autoRenew);
        self::assertFalse($registration->whoisPrivacy);
        self::assertEquals("2016-12-09T19:35:31Z", $registration->createdAt);
        self::assertEquals("2016-12-09T19:35:31Z", $registration->updatedAt);
    }

    public function testTransferDomain()
    {
        $this->mockResponseWith("transferDomain/success");
        $attributes = [
            "registrant_id" => 2,
            "auth_code" => "xjfjfjvhc293"
        ];
        $domainTransfer = $this->service->transferDomain(1010, "example.com", $attributes)->getData();

        self::assertInstanceOf(DomainTransfer::class, $domainTransfer);
        self::assertEquals(1, $domainTransfer->id);
        self::assertEquals(999, $domainTransfer->domainId);
        self::assertEquals(2, $domainTransfer->registrantId);
        self::assertEquals("transferring", $domainTransfer->state);
        self::assertFalse($domainTransfer->autoRenew);
        self::assertFalse($domainTransfer->whoisPrivacy);
        self::assertEquals("2016-12-09T19:43:41Z", $domainTransfer->createdAt);
        self::assertEquals("2016-12-09T19:43:43Z", $domainTransfer->updatedAt);
    }

    public function testTransferDomainMissingAuthCode()
    {
        $this->mockResponseWith("transferDomain/error-missing-authcode");
        $attributes = [
            "registrant_id" => 2
        ];
        $this->expectException(DnsimpleException::class);
        $this->expectExceptionMessage("You must provide an authorization code for the domain");

        $this->service->transferDomain(1010, "example.com", $attributes);
    }

    public function testTransferDomainErrorInDnsimple()
    {
        $this->mockResponseWith("transferDomain/error-indnsimple");
        $this->expectException(DnsimpleException::class);
        $this->expectExceptionMessage("The domain google.com is already in DNSimple and cannot be added");

        $attributes = [
            "registrant_id" => 2,
            "auth_code" => "12244"
        ];

        $this->service->transferDomain(1010, "google.com", $attributes);
    }

    public function testGetDomainTransfer()
    {
        $this->mockResponseWith("getDomainTransfer/success");
        $transfer = $this->service->getDomainTransfer(1010, "example.com", 361)->getData();

        self::assertEquals(361, $transfer->id);
        self::assertEquals(182245, $transfer->domainId);
        self::assertEquals(2715, $transfer->registrantId);
        self::assertEquals("cancelled", $transfer->state);
        self::assertFalse($transfer->autoRenew);
        self::assertFalse($transfer->whoisPrivacy);
        self::assertEquals("Canceled by customer", $transfer->statusDescription);
        self::assertEquals( "2020-06-05T18:08:00Z", $transfer->createdAt);
        self::assertEquals("2020-06-05T18:10:01Z", $transfer->updatedAt);

    }

    public function testCancelDomainTransfer()
    {
        $this->mockResponseWith("cancelDomainTransfer/success");

        $response = $this->service->cancelDomainTransfer(1010, "example.com", 361);
        $cancellation = $response->getData();

        self::assertEquals(202, $response->getStatusCode());
        self::assertInstanceOf(DomainTransfer::class, $cancellation);
        self::assertEquals("transferring", $cancellation->state);
    }

    public function testRenewDomain()
    {
        $this->mockResponseWith("renewDomain/success");

        $attributes = [
            "period" => 1
        ];
        $renewal = $this->service->renewDomain(1010, "example.com", $attributes)->getData();

        self::assertInstanceOf(DomainRenewal::class, $renewal);
        self::assertEquals(1, $renewal->id);
        self::assertEquals(999, $renewal->domainId);
        self::assertEquals(1, $renewal->period);
        self::assertEquals("new", $renewal->state);
        self::assertEquals("2016-12-09T19:46:45Z", $renewal->createdAt);
        self::assertEquals("2016-12-09T19:46:45Z", $renewal->updatedAt);
    }

    public function testRenewDomainTooEarly()
    {
        $this->mockResponseWith("renewDomain/error-tooearly");
        $this->expectException(DnsimpleException::class);
        $this->expectExceptionMessage("example.com may not be renewed at this time");

        $this->service->renewDomain(1010, "example.com", ["period" => 1]);
    }

    public function testTransferDomainOut()
    {
        $this->mockResponseWith("authorizeDomainTransferOut/success");

        $response = $this->service->transferDomainOut(1010, "example.com");

        self::assertEquals(204, $response->getStatusCode());
    }
}
