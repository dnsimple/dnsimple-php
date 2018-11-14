<?php

namespace Dnsimple;


class DomainsService extends ClientService
{
    /**
     * Lists the domains in the account.
     *
     * @param   int $accountId account ID
     * @return  Response
     */
    public function listDomains($accountId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains"));

        return new Response($response);
    }

    /**
     * Retrieves the details of an existing domain.
     *
     * @param   int $accountId account ID
     * @param   array $domainAttributes
     * @return  Response
     */
    public function createDomain($accountId, array $domainAttributes)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains"), [
            \GuzzleHttp\RequestOptions::JSON => $domainAttributes,
        ]);

        return new Response($response);
    }

    /**
     * Retrieves the details of an existing domain.
     *
     * @param   int $accountId account ID
     * @param   string $domainIdentifier domain name or ID
     * @return  Response
     */
    public function getDomain($accountId, $domainIdentifier)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        return new Response($response);
    }

    /**
     * Permanently deletes a domain from the account. It cannot be undone.
     *
     * @param   int $accountId account ID
     * @param   string $domainIdentifier domain name or ID
     * @return  Response
     */
    public function deleteDomain($accountId, $domainIdentifier)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        return new Response($response);
    }
}
