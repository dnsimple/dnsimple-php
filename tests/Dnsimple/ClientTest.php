<?php

use Dnsimple\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $client = new Client("a1b2c3");
        $this->assertInstanceOf('Dnsimple\Client', $client);
    }

    public function testVersioned_PrependsDefaultVersionToPath() {
        $this->assertEquals(Client::API_VERSION."/test", Client::versioned("test"));
    }
}
