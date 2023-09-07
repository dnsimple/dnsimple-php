<?php

namespace Dnsimple\Service;

use Dnsimple\Struct\DomainTransferLock;

class RegistrarTransferLockTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Registrar($this->client);
    }

    public function testGetDomainTransferLock()
    {
        $this->mockResponseWith("getDomainTransferLock/success");
        $transferLock = $this->service->getDomainTransferLock(1010, "example.com")->getData();

        self::assertInstanceOf(DomainTransferLock::class, $transferLock);
        self::assertEquals(true, $transferLock->enabled);
    }

    public function testEnableDomainTransferLock()
    {
        $this->mockResponseWith("enableDomainTransferLock/success");
        $transferLock = $this->service->enableDomainTransferLock(1010, "example.com")->getData();

        self::assertEquals(true, $transferLock->enabled);
    }

    public function testDisableDomainTransferLock()
    {
        $this->mockResponseWith("disableDomainTransferLock/success");
        $transferLock = $this->service->disableDomainTransferLock(1010, "example.com")->getData();

        self::assertEquals(false, $transferLock->enabled);
    }
}
