<?php


namespace Dnsimple\Struct;

/**
 * Represents a domain transfer lock
 *
 * @see https://developer.dnsimple.com/v2/registrar/
 * @package Dnsimple\Struct
 */
class DomainTransferLock
{
    /**
     * @var bool Indicates the domain transfer lock enabled status
     */
    public $enabled;

    public function __construct($data)
    {
        $this->enabled = $data->enabled;
    }
}
