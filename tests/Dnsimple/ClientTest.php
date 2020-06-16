<?php

namespace Dnsimple;

use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testConstructor()
    {
        $client = new Client("a1b2c3");
        $this->assertInstanceOf('Dnsimple\Client', $client);
    }

    public function testVersioned_PrependsDefaultVersionToPath()
    {
        $this->assertEquals("/" . Client::API_VERSION . "/test", Client::versioned("/test"));
    }
}
