<?php

namespace Dnsimple;


class ClientService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
