<?php

namespace Dnsimple\Struct;

use Brick\Math\BigDecimal;

/**
 * Represents a Charge Item.
 *
 * @see https://developer.dnsimple.com/v2/billing/
 * @package Dnsimple\Struct
 */

class ChargeItem
{
    /**
     * @var string The description of the charge item.
     */
    public $description;
    /**
     * @var object<BigDecimal> The amount of the charge item.
     */
    public $amount;
    /**
     * @var int The ID of the product that was charged.
     */
    public $productId;
    /**
     * @var string The type of the product that was charged.
     */
    public $productType;
    /**
     * @var string A unique or representative reference. For example, the domain name that was charged.
     *             Or the ID of the subscription or the order ID of the product.
     */
    public $productReference;

    public function __construct($data)
    {
        $this->description = $data->description;
        $this->amount = BigDecimal::of($data->amount);
        $this->productId = $data->product_id;
        $this->productType = $data->product_type;
        $this->productReference = $data->product_reference;
    }
}
