<?php


namespace Dnsimple\Struct;

/**
 * Represents a DNS Analytics record
 *
 * The groupings of the query set which fields have a value.
 *
 * @package Dnsimple\Struct
 */
class DnsAnalytics
{
    /**
     * @var string|null The zone name
     */
    public $zoneName;
    /**
     * @var string|null The date of the queries
     */
    public $date;
    /**
     * @var int|null The number of queries
     */
    public $volume;

    public function __construct($data)
    {
        $this->zoneName = $data->zone_name ?? null;
        $this->date = $data->date ?? null;
        $this->volume = $data->volume ?? null;
    }
}
