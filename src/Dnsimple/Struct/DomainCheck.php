<?php


namespace Dnsimple\Struct;

/**
 * Represents the result of a domain check
 * @package Dnsimple\Struct
 */
class DomainCheck
{
    /**
     * @var string The domain name
     */
    public $domain;
    /**
     * @var bool True if the domain is available
     */
    public $available;
    /**
     * @var bool True if the domain is a premium domain
     */
    public $premium;

    public function __construct($data)
    {
        $this->domain = $data->domain;
        $this->available = $data->available;
        $this->premium = $data->premium;
    }
}
