<?php

namespace Dnsimple\Service;

class RegistrantChangeTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testListRegistrantChanges()
    {
        $this->mockResponseWith("listRegistrantChanges/success");
        $response = $this->service->listRegistrantChanges(1010);

        self::assertEquals(200, $response->getStatusCode());
    }
}
