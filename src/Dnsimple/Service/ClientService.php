<?php

namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\DnsimpleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class ClientService
{
    /**
     * @var Client The DNSimple client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Convenience method adding the versioning to the GET request
     *
     * @param string $path The path to the service
     * @param array $options Any extra options passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    protected function get($path, array $options = []): ResponseInterface
    {
        return $this->client->get(Client::versioned($path), $options);
    }

    /**
     * Convenience method adding the versioning to the POST request
     *
     * @param string $path The path to the service
     * @param array $attributes Any extra attributes passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    protected function post($path, array $attributes = []): ResponseInterface
    {
        return $this->client->post(Client::versioned($path), [
            RequestOptions::JSON => $attributes,
        ]);
    }

    /**
     * Convenience method adding the versioning to the PATCH request
     *
     * @param string $path The path to the service
     * @param array $attributes Any extra attributes passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    protected function patch($path, array $attributes = []): ResponseInterface
    {
        return $this->client->patch(Client::versioned($path), [
            RequestOptions::JSON => $attributes,
        ]);
    }

    /**
     * Convenience method adding the versioning to the PUT request
     *
     * @param string $path The path to the service
     * @param array $attributes Any extra attributes passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    protected function put($path, array $attributes = []): ResponseInterface
    {
        return $this->client->put(Client::versioned($path), [
            RequestOptions::JSON => $attributes,
        ]);
    }

    /**
     * Convenience method adding the versioning to the DELETE request
     *
     * @param string $path The path to the service
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    protected function delete($path): ResponseInterface
    {
        return $this->client->delete(Client::versioned($path));
    }
}
