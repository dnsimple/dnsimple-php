<?php

use Dnsimple\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $client = new Client();
        $this->assertInstanceOf('Dnsimple\Client', $client);
    }
}
