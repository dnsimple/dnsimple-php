<?php


namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Service;

/**
 * Handles communication with the services related methods of the DNSimple API
 *
 * @see https://developer.dnsimple.com/v2/services
 * @package Dnsimple\Service
 */
class Services extends ClientService
{
    /**
     * List the available one-click services.
     *
     * @see https://developer.dnsimple.com/v2/services/#listServices
     *
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of services in DNSimple
     */
    public function listServices(array $options = [])
    {
        $response = $this->client->get(Client::versioned("/services"), $options);
        return new Response($response, Service::class);
    }

    /**
     * Gets the service with specified ID
     *
     * @see https://developer.dnsimple.com/v2/services/#getService
     *
     * @param int|string $service The service name or id
     * @return Response The service requested
     */
    public function getService($service)
    {
        $response = $this->client->get(Client::versioned("/services/{$service}"));
        return new Response($response, Service::class);
    }
}
