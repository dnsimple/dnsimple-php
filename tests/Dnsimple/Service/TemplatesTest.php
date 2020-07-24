<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Template;

class TemplatesTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Templates($this->client);
    }

    public function testListTemplates()
    {
        $this->mockResponseWith("listTemplates/success");

        $response = $this->service->listTemplates(1010);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(2, $data);

        $template = $data[0];
        self::assertInstanceOf(Template::class, $template);
    }

    public function testListTemplatesSupportsSorting()
    {
        $this->mockResponseWith("listTemplates/success");

        $this->service->listTemplates(1010, ["sort" => "id:asc,name:desc,sid:asc"]);

        self::assertEquals("sort=id%3Aasc%2Cname%3Adesc%2Csid%3Aasc", $this->queryContent());

    }

    public function testListTemplatesHasPaginationObject()
    {
        $this->mockResponseWith("listTemplates/success");

        $response = $this->service->listTemplates(1010);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListTemplatesSupportsPagination()
    {
        $this->mockResponseWith("listTemplates/success");

        $this->service->listTemplates(1010, ["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testCreateTemplate()
    {
        $this->mockResponseWith("createTemplate/created");

        $attributes = [
            "name" => "Beta",
            "sid" => "beta",
            "description" => "A beta template."
        ];

        $template = $this->service->createTemplate(1010, $attributes)->getData();

        self::assertInstanceOf(Template::class, $template);
    }

    public function testGetTemplate()
    {
        $this->mockResponseWith("getTemplate/success");

        $template = $this->service->getTemplate(1010, "alpha")->getData();

        self::assertEquals(1, $template->id);
        self::assertEquals(1010, $template->accountId);
        self::assertEquals("Alpha", $template->name);
        self::assertEquals("alpha", $template->sid);
        self::assertEquals("An alpha template.", $template->description);
        self::assertEquals("2016-03-22T11:08:58Z", $template->createdAt);
        self::assertEquals("2016-03-22T11:08:58Z", $template->updatedAt);
    }

    public function testUpdateTemplate()
    {
        $this->mockResponseWith("updateTemplate/success");

        $attributes = [
            "name" => "Beta",
            "sid" => "beta",
            "description" => "A beta template."
        ];

        $template = $this->service->updateTemplate(1010, 1, $attributes)->getData();

        self::assertInstanceOf(Template::class, $template);
    }

    public function testDeleteTemplate()
    {
        $this->mockResponseWith("deleteTemplate/success");

        $response = $this->service->deleteTemplate(1010, 1);

        self::assertEquals(204, $response->getStatusCode());
    }
}
