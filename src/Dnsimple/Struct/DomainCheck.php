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
    public string $domain;
    /**
     * @var bool True if the domain is available
     */
    public bool $available;
    /**
     * @var bool True if the domain is a premium domain
     */
    public bool $premium;

    public function __construct($data)
    {
        $this->domain = $data->domain;
        $this->available = $data->available;
        $this->premium = $data->premium;
    }
}
