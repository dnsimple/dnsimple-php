<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\DomainResearchStatus;

/**
 * The DomainsResearch trait provides domain research functionality.
 *
 * @package Dnsimple
 */
trait DomainsResearch
{
    /**
     * Research a domain name for availability and registration status information.
     *
     * This endpoint provides information about a domain's availability status.
     *
     * @see https://developer.dnsimple.com/v2/domains/research/#getDomainsResearchStatus
     *
     * @param int $account The account id
     * @param string $domain The domain name to research
     * @return Response The domain research result
     * @throws \Dnsimple\DnsimpleException When something goes wrong
     */
    public function domainResearchStatus($account, $domain): Response
    {
        $response = $this->get("/{$account}/domains/research/status", ["domain" => $domain]);
        return new Response($response, DomainResearchStatus::class);
    }
}
