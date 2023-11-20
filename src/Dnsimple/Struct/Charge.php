<?php

namespace Dnsimple\Struct;

use Brick\Math\BigDecimal;

/**
 * Represents a Charge.
 *
 * @see https://developer.dnsimple.com/v2/billing/
 * @package Dnsimple\Struct
 */

class Charge
{
    /**
     * @var string The date and time the charge was invoiced in DNSimple.
     */
    public $invoicedAt;
    /**
     * @var object<BigDecimal> The aggregate amount of all line items, that need to be paid.
     */
    public $totalAmount;
    /**
     * @var object<BigDecimal> The amount that was paid via wallet.
     */
    public $balanceAmount;
    /**
     * @var string The reference number of the invoice.
     */
    public $reference;
    /**
     * @var string The state of the charge.
     */
    public $state;
    /**
     * @var array<ChargeItem> The line items of the charge.
     */
    public $items;

    public function __construct($data)
    {
        $items = [];

        $this->invoicedAt = $data->invoiced_at;
        $this->totalAmount = BigDecimal::of($data->total_amount);
        $this->balanceAmount = BigDecimal::of($data->balance_amount);
        $this->reference = $data->reference;
        $this->state = $data->state;
        # Convert items to ChargeItem objects
        foreach ($data->items as $item) {
            $items[] = new ChargeItem($item);
        }
        $this->items = $items;
    }
}

