<?php

use Dnsimple\Client;

class MiscTest extends PHPUnit_Framework_TestCase
{
    public function testTest() {
        $client = new Client(getenv('DNSIMPLE_ACCESS_TOKEN'));
        $service = new \Dnsimple\MiscService($client);
        $response = $service->whoami();

        echo $response->getStatusCode();
        echo $response->getBody();
    }
}
