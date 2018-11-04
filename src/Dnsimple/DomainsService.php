<?php

namespace Dnsimple;


class DomainsService extends ClientService
{
    /**
     * Retrieves the details of an existing domain.
     *
     * @param   int $accountId account ID
     * @param   string $domainIdentifier domain name or ID
     * @return  stdClass
     */
    public function getDomain($accountId, $domainIdentifier)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        $json = json_decode($response->getBody());
        return $json->data;
    }
}
