<?php

namespace Dnsimple;

use Dnsimple\DnsimpleException;
use Dnsimple\Exceptions\BadRequestException;
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
        self::assertEquals(400, $e->getStatusCode());
        self::assertEquals("Validation failed", $e->getMessage());
        self::assertEquals(["can't be blank"], $e->getErrors()["address1"]);
      }
  }
}

