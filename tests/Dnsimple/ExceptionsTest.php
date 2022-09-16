<?php

namespace Dnsimple;

use Dnsimple\DnsimpleException;
use Dnsimple\Exceptions\BadRequestException;
use Dnsimple\Exceptions\NotFoundException;
use Dnsimple\Exceptions\HttpException;
use Dnsimple\Service\ServiceTestCase;
use Dnsimple\Service\Domains;
use Dnsimple\Response;

final class ExceptionsTest extends ServiceTestCase
{
  public function testValidationResponse()
  {
      $service = new Domains($this->client);
      $this->mockResponseWith("validation-error");

      try {
        $response = $service->listDomains(1);
      } catch(BadRequestException $e) {
        self::assertEquals(400, $e->getCode());
        self::assertEquals(400, $e->getStatusCode());
        self::assertEquals("Validation failed", $e->getMessage());
        self::assertEquals(["can't be blank"], $e->getAttributeErrors()["address1"]);
      }
  }

  public function testNotFoundResponse()
  {
      $service = new Domains($this->client);
      $this->mockResponseWith("notfound-domain");

      try {
        $response = $service->listDomains(1);
      } catch(NotFoundException $e) {
        self::assertEquals(404, $e->getCode());
        self::assertEquals(404, $e->getStatusCode());
        self::assertEquals("Domain `0` not found", $e->getMessage());
        self::assertEquals(null, $e->getAttributeErrors());
      }
  }

  public function testClientErrorResponse()
  {
      $service = new Domains($this->client);
      $this->mockResponseWith("method-not-allowed");

      try {
        $response = $service->listDomains(1);
      } catch(HttpException $e) {
        self::assertEquals(405, $e->getCode());
        self::assertEquals(405, $e->getStatusCode());
        self::assertEquals("Method Not Allowed", $e->getMessage());
        self::assertEquals(null, $e->getAttributeErrors());
      }
  }

  public function testServerErrorResponse()
  {
      $service = new Domains($this->client);
      $this->mockResponseWith("badgateway");
      $this->expectException(DnsimpleException::class);

      $response = $service->listDomains(1);
  }
}

