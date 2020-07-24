<?php


namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
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
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response The vanity name server list
     * @throws DnsimpleException When something goes wrong
     */
    public function enableVanityNameServers($account, $domain): Response
    {
        $response = $this->put("/{$account}/vanity/{$domain}");
        return new Response($response, VanityNameServer::class);
    }

    /**
     * Disables Vanity Name Servers for the domain
     *
     * @see https://developer.dnsimple.com/v2/vanity/#disableVanityNameServers
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function disableVanityNameServers($account, $domain): Response
    {
        $response = $this->delete("/{$account}/vanity/{$domain}");
        return new Response($response);
    }
}
