<?php


namespace Dnsimple\Struct;

/**
 * Represents the result of a domain prices
 * @package Dnsimple\Struct
 */
class DomainPrice
{
    /**
     * @var string The domain name
     */
    public $domain;
    /**
     * @var bool True if the domain is premium
     */
    public $premium;
    /**
     * @var float The registration price
     */
    public $registrationPrice;
    /**
     * @var float The renewal price
     */
    public $renewalPrice;
    /**
     * @var float The transfer price
     */
    public $transferPrice;

    public function __construct($data)
    {
        $this->domain = $data->domain;
        $this->premium = $data->premium;
        $this->registrationPrice = $data->registration_price;
        $this->renewalPrice = $data->renewal_price;
        $this->transferPrice = $data->transfer_price;
    }
}
