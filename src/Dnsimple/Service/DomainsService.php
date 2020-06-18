<?php

namespace Dnsimple\Service;

use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Collaborator;
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
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible options:
     *  - filters:
     *      - name_like: Only include domains containing given string (i.e. ['name_like' => 'example.com'] )
     *      - registrant_id: Only include domains containing given registrant ID (i.e. ['registrant_id' => 1010] )
     *  - sorting:
     *    Comma separated key-value pairs: the name of a field and the order criteria (asc for ascending and desc for
     *    descending).
     *    Sort criteria:
     *      - id: Sort domains by ID (i.e. 'id:asc')
     *      - name: Sort domains by name (alphabetical order) (i.e. 'name:desc')
     *      - expiration: Sort domains by expiration date (i.e. 'expiration:asc')
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
     * @example listDomains(1010, ["name_like" => "example.com", "sort" => "id:desc,expiration:asc"]
     * @return  Response The list of domains
     */
    public function listDomains($accountId, $options = []): Response
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains"), $options);

        return new Response($response, Domain::class);
    }

    /**
     * Creates a domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/#create
     *
     * @param   int $accountId The account ID
     * @param   array $domainAttributes The domain attributes (currently ["name" => "domain_name.com"])
     * @return  Response The newly created domain
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
     * @param   int|string $domainIdentifier The domain name or ID
     * @return  Response The domain requested
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
     * @param   int|string $domainIdentifier The domain name or ID
     * @return  Response An empty response
     */
    public function deleteDomain($accountId, $domainIdentifier): Response
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        return new Response($response, null);
    }

    /**
     * List collaborators for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#listDomainCollaborators
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or ID
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
     * @return Response The list of collaborators
     */
    public function listCollaborators($accountId, $domainIdentifier, array $options = []): Response
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/collaborators"), $options);
        return new Response($response, Collaborator::class);
    }

    /**
     * Adds a collaborator for the domain in the account
     *
     * At the time of the add, a collaborator may or may not have a DNSimple account.
     *
     * In case the collaborator doesn't have a DNSimple account, the system will invite her/him to register to
     * DNSimple first and then to accept the collaboration invitation.
     *
     * In the other case, she/he is automatically added to the domain as collaborator. She/he can decide to reject
     * the invitation later.
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#addDomainCollaborator
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or ID
     * @param array $collaboratorAttributes The collaborator attributes (i.e. ["email" => "user@example.com"])
     * @return Response The collaborator added to the domain in the account
     */
    public function addCollaborator($accountId, $domainIdentifier, array $collaboratorAttributes)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/collaborators"), $collaboratorAttributes);
        return new Response($response, Collaborator::class);
    }

    /**
     * Remove a collaborator from the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#removeDomainCollaborator
     *
     * @param int $accountId The account Id
     * @param string $domainIdentifier The domain name or id
     * @param int $collaboratorId The collaborator id
     * @return Response An empty response
     */
    public function removeCollaborator($accountId, $domainIdentifier, $collaboratorId)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/collaborators/{$collaboratorId}"));
        return new Response($response, null);
    }
}
