<?php


namespace Dnsimple\Struct;

/**
 * Represents the premium price for a premium domain
 * @package Dnsimple\Struct
 */
class DomainPremiumPrice
{
    /**
     * @var string The domain premium price
     */
    public $premiumPrice;
    /**
     * @var string The action (either registration, transfer or renewal)
     */
    public $action;

    public function __construct($data)
    {
        $this->premiumPrice = $data->premium_price;
        $this->action = $data->action;
    }
}
