<?php


namespace Dnsimple\Service;

use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\VanityNameServer;

/**
 * Handles communication with the vanity name server related methods of the DNSimple API
 * @see https://developer.dnsimple.com/v2/vanity/
 * @package Dnsimple\Service
 */
class VanityNameServers extends ClientService
{
    /**
     * Enables Vanity Name Servers for the domain
     *
     * @see https://developer.dnsimple.com/v2/vanity/#enableVanityNameServers
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response The vanity name server list
     */
    public function enableVanityNameServers($accountId, $domain)
    {
        $response = $this->client->put(Client::versioned("/{$accountId}/vanity/{$domain}"));
        return new Response($response, VanityNameServer::class);
    }

    /**
     * Disables Vanity Name Servers for the domain
     *
     * @see https://developer.dnsimple.com/v2/vanity/#disableVanityNameServers
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     */
    public function disableVanityNameServers($accountId, $domain)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/vanity/{$domain}"));
        return new Response($response);
    }
}
