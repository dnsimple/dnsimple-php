<?php

namespace Dnsimple;

use Dnsimple\Struct\DnsAnalytics;
use Dnsimple\Struct\DnsAnalyticsQuery;

/**
 * Wrapper holding the response of a DNS Analytics query.
 *
 * @package Dnsimple
 */
class DnsAnalyticsResponse extends Response
{
    /**
     * Returns one DnsAnalytics record for each row in the response body.
     *
     * @return DnsAnalytics[] The DNS Analytics records
     */
    public function getData()
    {
        $data = $this->getJson()->data;
        return array_map(function($row) use ($data) {
            return new DnsAnalytics((object) array_combine($data->headers, $row));
        }, $data->rows);
    }

    /**
     * Returns the query parameters that produced the result.
     *
     * @return DnsAnalyticsQuery The query object.
     */
    public function getQuery()
    {
        return new DnsAnalyticsQuery($this->getJson()->query);
    }
}
