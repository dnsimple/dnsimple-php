<?php


namespace Dnsimple\Service;


use Dnsimple\DnsAnalyticsResponse;
use Dnsimple\DnsimpleException;

/**
 * Handles communication with the DNS Analytics related methods of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/dns-analytics
 * @package Dnsimple\Service
 */
class DnsAnalytics extends ClientService
{
    /**
     * Queries DNS Analytics data for the account. The API is in Public Beta.
     *
     * @see https://developer.dnsimple.com/v2/dns-analytics/#queryDnsAnalytics
     *
     * @param int $account The account id
     * @param array $options key/value options to filter, group, sort, and paginate the results
     * @return DnsAnalyticsResponse The DNS Analytics records
     * @throws DnsimpleException When something goes wrong
     */
    public function query($account, array $options = []): DnsAnalyticsResponse
    {
        $response = $this->get("/{$account}/dns_analytics", $options);
        return new DnsAnalyticsResponse($response);
    }
}
