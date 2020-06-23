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

    /**
     * List services applied to a domain
     *
     * @see https://developer.dnsimple.com/v2/services/domains/#listDomainAppliedServices
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of services applied to the domain
     */
    public function appliedServices($accountId, $domain, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domain}/services"), $options);
        return new Response($response, Service::class);
    }

    /**
     * Applies a service to a domain
     *
     * @see https://developer.dnsimple.com/v2/services/domains/#applyServiceToDomain
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int|string $service The service name or id
     * @param array $settings
     * @return Response An empty response
     */
    public function applyService($accountId, $domain, $service, array $settings = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domain}/services/{$service}"), $settings);
        return new Response($response);
    }

    /**
     * Un-applies a service from a domain
     *
     * @see https://developer.dnsimple.com/v2/services/domains/#unapplyServiceFromDomain
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int|string $service The service name or id
     * @return Response An empty response
     */
    public function unapplyService($accountId, $domain, $service)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domain}/services/{$service}"));
        return new Response($response);
    }
}
