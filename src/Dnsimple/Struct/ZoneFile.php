<?php


namespace Dnsimple\Struct;

/**
 * Represents a zone file
 * @package Dnsimple\Struct
 */
class ZoneFile
{
    /**
     * @var string The zone file content
     */
    public string $zone;

    public function __construct($data)
    {
        $this->zone = $data->zone;
    }

}
