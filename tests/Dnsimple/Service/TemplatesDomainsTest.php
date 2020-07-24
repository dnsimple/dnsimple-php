<?php

namespace Dnsimple\Service;

class TemplatesDomainsTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Templates($this->client);
    }

    public function testApplyTemplate()
    {
        $this->mockResponseWith("applyTemplate/success");

        $response = $this->service->applyTemplate(1010, "example.com", 42);

        self::assertEquals(204, $response->getStatusCode());
    }
}
