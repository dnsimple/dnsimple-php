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
        $this->assertCount(2, $data);

        $collaborator = $data[0];
        $this->assertInstanceOf(Collaborator::class, $collaborator);
    }

    public function testListCollaboratorsHasPaginationObject()
    {
        $this->mockResponseWith("listCollaborators/success");
        $response = $this->service->listCollaborators(1010, 100);
        $pagination = $response->getPagination();

        $this->assertEquals(1, $pagination->currentPage);
        $this->assertEquals(30, $pagination->perPage);
        $this->assertEquals(2, $pagination->totalEntries);
        $this->assertEquals(1, $pagination->totalPages);
    }

    public function testListCollaboratorsSupportsPagination()
    {
        $this->mockResponseWith("listCollaborators/success");
        $this->service->listCollaborators(1010, 100, ["page" => 1, "per_page" => 4]);

        $this->assertEquals("page=1&per_page=4", $this->mockHandler->getLastRequest()->getUri()->getQuery());
    }

    public function testAddExistingDNSimpleCollaborator()
    {
        $this->mockResponseWith("addCollaborator/success");
        $collaborator = $this->service->addCollaborator(1010, 1, [ "email" => "existing-user@example.com"])->getData();

        $this->assertEquals(100, $collaborator->id);
        $this->assertEquals(1, $collaborator->domainId);
        $this->assertEquals("example.com", $collaborator->domainName);
        $this->assertEquals(999, $collaborator->userId);
        $this->assertEquals("existing-user@example.com", $collaborator->userEmail);
        $this->assertFalse($collaborator->invitation);
        $this->assertEquals("2016-10-07T08:53:41Z", $collaborator->createdAt);
        $this->assertEquals("2016-10-07T08:53:41Z", $collaborator->updatedAt);
        $this->assertEquals("2016-10-07T08:53:41Z", $collaborator->acceptedAt);
    }

    public function testAddInvitedCollaborator()
    {
        $this->mockResponseWith("addCollaborator/invite-success");
        $collaborator = $this->service->addCollaborator(1010, "example.com", [ "email" => "invited-user@example.com"])->getData();

        $this->assertTrue($collaborator->invitation);
    }

    public function testRemoveCollaborator()
    {
        $this->mockResponseWith("removeCollaborator/success");
        $response = $this->service->removeCollaborator(1010, 1, 12);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }
}
