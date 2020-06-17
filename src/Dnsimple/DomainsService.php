<?php

namespace Dnsimple;

use Dnsimple\Struct\Domain;
use GuzzleHttp\RequestOptions;

/**
 * The Domains Service handles the domains endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/domains
 * @package Dnsimple
 */
class DomainsService extends ClientService
{
    /**
     * Lists the domains in the account.
     *
     * @param int $accountId The account ID
     * @param array $filters Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible filters:
     *    - name_like: Only include domains containing given string (i.e. {'name_like': 'example.com'} )
     *    - registrant_id: Only include domains containing given registrant ID (i.e. {'registrant_id': 1010} )
     * @param ?string $sorting Comma separated key-value pairs: the name of a field and the order criteria
     *                         (asc for ascending and desc for descending).
     *
     * Possible sort criteria:
     *    - id: Sort domains by ID (i.e. 'id:asc')
     *    - name: Sort domains by name (alphabetical order) (i.e. 'name:desc')
     *    - expiration: Sort domains by expiration date (i.e. 'expiration:asc')
     * @return  Response The response containing a list of domains
     */
    public function listDomains($accountId, $filters = [], $sorting = null): Response
    {
        $sort = [];
        if (!is_null($sorting))
            $sort = ['sort'=>$sorting];
        $response = $this->client->get(Client::versioned("/{$accountId}/domains"), $filters, $sort);

        return new Response($response, Domain::class);
    }

    /**
     * Creates a domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/#create
     *
     * @param   int $accountId The account ID
     * @param   array $domainAttributes The domain attributes (currently ["name" => "domain_name.com"])
     * @return  Response The response containing the newly created domain
     */
    public function createDomain($accountId, array $domainAttributes): Response
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains"), [
            RequestOptions::JSON => $domainAttributes,
        ]);

        return new Response($response, Domain::class);
    }

    /**
     * Retrieves the details of an existing domain.
     *
     * @see https://developer.dnsimple.com/v2/domains/#getDomain
     *
     * @param   int $accountId The account ID
     * @param   string $domainIdentifier The domain name or ID
     * @return  Response The response containing the domain requested
     */
    public function getDomain($accountId, $domainIdentifier): Response
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        return new Response($response, Domain::class);
    }

    /**
     * Permanently deletes a domain from the account.
     *
     * For domains which are registered with DNSimple, this will not delete the domain from the registry,
     * nor perform a refund.
     *
     * @see https://developer.dnsimple.com/v2/domains/#deleteDomain
     *
     * @param   int $accountId The account ID
     * @param   string $domainIdentifier The domain name or ID
     * @return  Response An empty response
     */
    public function deleteDomain($accountId, $domainIdentifier): Response
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        return new Response($response, null);
    }
}
