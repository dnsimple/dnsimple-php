<?php

namespace Dnsimple\Service;

use Dnsimple\Exceptions\NotFoundException;
use Dnsimple\Response;
use Dnsimple\Struct\RegistrantChange;
use Dnsimple\Struct\RegistrantChangeCheck;

class RegistrarRegistrantChangeTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testListRegistrantChanges()
    {
        $this->mockResponseWith("listRegistrantChanges/success");

        $response = $this->service->listRegistrantChanges(101);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $registrantChanges = $response->getData();
        self::assertCount(1, $registrantChanges);
        self::assertInstanceOf(RegistrantChange::class, $registrantChanges[0]);
    }

    public function testListRegistrantChangesSupportsFilters()
    {
        $this->mockResponseWith("listRegistrantChanges/success");
        $this->service->listRegistrantChanges(101, ["contact_id" => 101, "domain_id" => 101, "state" => "new"]);

        self::assertEquals("contact_id=101&domain_id=101&state=new", $this->queryContent());
    }

    public function testListRegistrantChangesSupportsSorting()
    {
        $this->mockResponseWith("listRegistrantChanges/success");

        $this->service->listRegistrantChanges(101, ["sort" => "id:asc"]);

        self::assertEquals("sort=id%3Aasc", $this->queryContent());
    }

    public function testListRegistrantChangesHasPaginationObject()
    {
        $this->mockResponseWith("listRegistrantChanges/success");

        $response = $this->service->listRegistrantChanges(101);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(1, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListRegistrantChangesSupportsPagination()
    {
        $this->mockResponseWith("listRegistrantChanges/success");

        $this->service->listRegistrantChanges(101, ["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testCreateRegistrantChange()
    {
        $this->mockResponseWith("createRegistrantChange/success");

        $attributes = [
            "domain_id" => 101,
            "contact_id" => 102,
        ];

        $registrantChange = $this->service->createRegistrantChange(101, $attributes)->getData();
        self::assertInstanceOf(RegistrantChange::class, $registrantChange);
    }

    public function testGetRegistrantChange()
    {
        $this->mockResponseWith("GetRegistrantChange/success");

        $registrantChange = $this->service->getRegistrantChange(101, 101)->getData();

        self::assertInstanceOf(RegistrantChange::class, $registrantChange);

        self::assertEquals(101, $registrantChange->id);
        self::assertEquals(101, $registrantChange->accountId);
        self::assertEquals(101, $registrantChange->domainId);
        self::assertEquals(101, $registrantChange->contactId);
        self::assertEquals("new", $registrantChange->state);
        self::assertEquals(true, $registrantChange->registryOwnerChange);
        self::assertEquals(null, $registrantChange->irtLockLiftedBy);
        self::assertEquals("2017-02-03T17:43:22Z", $registrantChange->createdAt);
        self::assertEquals("2017-02-03T17:43:22Z", $registrantChange->updatedAt);
        self::assertTrue(empty((array)$registrantChange->extendedAttributes));
    }

    public function testDeleteRegistrantChange()
    {
        $this->mockResponseWith("deleteRegistrantChange/success");
        $response = $this->service->deleteRegistrantChange(101, 101);

        self::assertEquals(201, $response->getStatusCode());
    }

    public function testCheckRegistrantChange()
    {
        $this->mockResponseWith("checkRegistrantChange/success");

        $attributes = [
            "domain_id" => 101,
            "contact_id" => 101,
        ];

        $registrantChangeCheck = $this->service->checkRegistrantChange(101, $attributes)->getData();
        self::assertInstanceOf(RegistrantChangeCheck::class, $registrantChangeCheck);
    }

    public function testCheckRegistrantChangeErrorContactNotFound()
    {
        $this->mockResponseWith("checkRegistrantChange/error-contactnotfound");

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Contact `21` not found");

        $attributes = [
            "domain_id" => 101,
            "contact_id" => 21,
        ];

        $this->service->checkRegistrantChange(101, $attributes);
    }

    public function testCheckRegistrantChangeErrorDomainNotFound()
    {
        $this->mockResponseWith("checkRegistrantChange/error-domainnotfound");

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Domain `dnsimple-rraform.bio` not found");

        $attributes = [
            "domain_id" => "dnsimple-rraform.bio",
            "contact_id" => 101,
        ];

        $this->service->checkRegistrantChange(101, $attributes);
    }
}
