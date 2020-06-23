<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Tld;
use Dnsimple\Struct\TldExtendedAttribute;

class TldsTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Tlds($this->client);
    }

    public function testListTlds()
    {
        $this->mockResponseWith("listTlds/success");
        $this->mockResponseWith("listTlds/success");

        $response = $this->service->listTlds();
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(2, $data);

        $tld = $data[0];
        self::assertInstanceOf(Tld::class, $tld);
    }

    public function testListTldsSupportsSorting()
    {
        $this->mockResponseWith("listTlds/success");
        $this->service->listTlds(["sort" => "tld:asc"]);

        self::assertEquals("sort=tld%3Aasc", $this->queryContent());
    }

    public function testListTldsHasPaginationObject()
    {
        $this->mockResponseWith("listTlds/success");

        $response = $this->service->listTlds();
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(2, $pagination->perPage);
        self::assertEquals(195, $pagination->totalEntries);
        self::assertEquals(98, $pagination->totalPages);
    }

    public function testListTldsSupportsPagination()
    {
        $this->mockResponseWith("listTlds/success");
        $this->service->listTlds(["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testGetTld()
    {
        $this->mockResponseWith("getTld/success");

        $tld = $this->service->getTld("com")->getData();

        self::assertEquals("com", $tld->tld);
        self::assertEquals(1, $tld->tldType);
        self::assertTrue($tld->whoisPrivacy);
        self::assertFalse($tld->autoRenewOnly);
        self::assertTrue($tld->idn);
        self::assertEquals(1, $tld->minimumRegistration);
        self::assertTrue($tld->registrationEnabled);
        self::assertTrue($tld->renewalEnabled);
        self::assertTrue($tld->transferEnabled);
    }

    public function testGetTldExtendedAttributes()
    {
        $this->mockResponseWith("getTldExtendedAttributes/success");

        $attributes = $this->service->getTldExtendedAttributes("com")->getData();
        $attribute = $attributes[0];

        self::assertInstanceOf(TldExtendedAttribute::class, $attribute);
        self::assertEquals("uk_legal_type", $attribute->name);
        self::assertEquals("Legal type of registrant contact", $attribute->description);
        self::assertFalse($attribute->required);
        self::assertCount(17, $attribute->options);

        $option = $attribute->options[0];
        self::assertEquals("UK Individual", $option->title);
        self::assertEquals("IND", $option->value);
        self::assertEquals("UK Individual (our default value)", $option->description);
    }

    public function testGetTldExtendedAttributesNoAttributes()
    {
        $this->mockResponseWith("getTldExtendedAttributes/success-noattributes");
        $attributes = $this->service->getTldExtendedAttributes("com")->getData();

        self::assertCount(0, $attributes);
    }
}
