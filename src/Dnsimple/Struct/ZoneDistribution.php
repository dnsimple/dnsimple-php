<?php


namespace Dnsimple\Struct;

/**
 * Represents the zone distribution
 * @package Dnsimple\Struct
 */
class ZoneDistribution
{
    /**
     * @var bool True if the zone is properly distributed across all DNSimple name servers.
     */
    public $distributed;

    public function __construct($data)
    {
        $this->distributed = $data->distributed;
    }
}
