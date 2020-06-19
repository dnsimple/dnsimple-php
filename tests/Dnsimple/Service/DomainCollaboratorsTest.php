<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Collaborator;

class DomainCollaboratorsTest extends ServiceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DomainsService($this->client);
    }

    public function testListCollaborators()
    {
        $this->mockResponseWith("listCollaborators/success");
        $response = $this->service->listCollaborators(1010, 100);

        $data = $response->getData();
        self::assertCount(2, $data);

        $collaborator = $data[0];
        self::assertInstanceOf(Collaborator::class, $collaborator);
    }

    public function testListCollaboratorsHasPaginationObject()
    {
        $this->mockResponseWith("listCollaborators/success");
        $response = $this->service->listCollaborators(1010, 100);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListCollaboratorsSupportsPagination()
    {
        $this->mockResponseWith("listCollaborators/success");
        $this->service->listCollaborators(1010, 100, ["page" => 1, "per_page" => 4]);

        self::assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testAddExistingDNSimpleCollaborator()
    {
        $this->mockResponseWith("addCollaborator/success");
        $collaborator = $this->service->addCollaborator(1010, 1, [ "email" => "existing-user@example.com"])->getData();

        self::assertEquals(100, $collaborator->id);
        self::assertEquals(1, $collaborator->domainId);
        self::assertEquals("example.com", $collaborator->domainName);
        self::assertEquals(999, $collaborator->userId);
        self::assertEquals("existing-user@example.com", $collaborator->userEmail);
        self::assertFalse($collaborator->invitation);
        self::assertEquals("2016-10-07T08:53:41Z", $collaborator->createdAt);
        self::assertEquals("2016-10-07T08:53:41Z", $collaborator->updatedAt);
        self::assertEquals("2016-10-07T08:53:41Z", $collaborator->acceptedAt);
    }

    public function testAddInvitedCollaborator()
    {
        $this->mockResponseWith("addCollaborator/invite-success");
        $collaborator = $this->service->addCollaborator(1010, "example.com", [ "email" => "invited-user@example.com"])->getData();

        self::assertTrue($collaborator->invitation);
    }

    public function testRemoveCollaborator()
    {
        $this->mockResponseWith("removeCollaborator/success");
        $response = $this->service->removeCollaborator(1010, 1, 12);

        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(204, $response->getStatusCode());
    }
}
