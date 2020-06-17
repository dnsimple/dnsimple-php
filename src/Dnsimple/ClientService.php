<?php

namespace Dnsimple;


class ClientService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
