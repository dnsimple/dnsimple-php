<?php


namespace Dnsimple\Struct;

/**
 * Represents the result of a domain research
 * @package Dnsimple\Struct
 */
class DomainResearchStatus
{
    /**
     * @var string UUID identifier for this research request
     */
    public $request_id;
    /**
     * @var string The domain name that was researched
     */
    public $domain;
    /**
     * @var string The availability status. See https://developer.dnsimple.com/v2/domains/research/#getDomainsResearchStatus
     */
    public $availability;
    /**
     * @var array Array of error messages if the domain cannot be registered or researched
     */
    public $errors;

    public function __construct($data)
    {
        $this->request_id = $data->request_id;
        $this->domain = $data->domain;
        $this->availability = $data->availability;
        $this->errors = $data->errors;
    }
}
