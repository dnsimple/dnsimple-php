<?php

namespace Dnsimple\Service;


use Dnsimple\Client;

class ClientService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
