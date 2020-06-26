<?php

namespace Dnsimple\Service;


use Dnsimple\Client;
use GuzzleHttp\RequestOptions;

class ClientService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function get($path, array $options = [])
    {
        return $this->client->get(Client::versioned($path), $options);
    }

    protected function post($path, array $attributes = [])
    {
        return $this->client->post(Client::versioned($path), [
            RequestOptions::JSON => $attributes,
        ]);
    }

    protected function patch($path, array $attributes = [])
    {
        return $this->client->patch(Client::versioned($path), [
            RequestOptions::JSON => $attributes,
        ]);
    }

    protected function put($path, array $attributes = [])
    {
        return $this->client->put(Client::versioned($path), [
            RequestOptions::JSON => $attributes,
        ]);
    }

    protected function delete($path)
    {
        return $this->client->delete(Client::versioned($path));
    }
}
