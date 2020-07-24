<?php


namespace Dnsimple\Service;


use Dnsimple\DnsimpleException;
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
     * @throws DnsimpleException When something goes wrong
     */
    public function listServices(array $options = []): Response
    {
        $response = $this->get("/services", $options);
        return new Response($response, Service::class);
    }

    /**
     * Gets the service with specified ID
     *
     * @see https://developer.dnsimple.com/v2/services/#getService
     *
     * @param int|string $service The service name or id
     * @return Response The service requested
     * @throws DnsimpleException When something goes wrong
     */
    public function getService($service): Response
    {
        $response = $this->get("/services/{$service}");
        return new Response($response, Service::class);
    }

    /**
     * List services applied to a domain
     *
     * @see https://developer.dnsimple.com/v2/services/domains/#listDomainAppliedServices
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $options key/value options to paginate the results
     * @return Response The list of services applied to the domain
     * @throws DnsimpleException When something goes wrong
     */
    public function appliedServices($account, $domain, array $options = []): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}/services", $options);
        return new Response($response, Service::class);
    }

    /**
     * Applies a service to a domain
     *
     * @see https://developer.dnsimple.com/v2/services/domains/#applyServiceToDomain
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int|string $service The service name or id
     * @param array $settings
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function applyService($account, $domain, $service, array $settings = []): Response
    {
        $response = $this->post("/{$account}/domains/{$domain}/services/{$service}", $settings);
        return new Response($response);
    }

    /**
     * Un-applies a service from a domain
     *
     * @see https://developer.dnsimple.com/v2/services/domains/#unapplyServiceFromDomain
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int|string $service The service name or id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function unapplyService($account, $domain, $service): Response
    {
        $response = $this->delete("/{$account}/domains/{$domain}/services/{$service}");
        return new Response($response);
    }
}
