<?php


namespace Dnsimple\Struct;

/**
 * Represents a Zone
 *
 * @see  https://developer.dnsimple.com/v2/zones
 * @package Dnsimple\Struct
 */
class Zone
{
    /**
     * @var int The zone ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated account ID in DNSimple
     */
    public $accountId;
    /**
     * @var string The zone name
     */
    public $name;
    /**
     * @var bool True if the zone is a reverse zone
     */
    public $reverse;
    /**
     * @var bool True if the zone is a secondary zone
     */
    public $secondary;
    /**
     * @var string The zone's last transfer date
     */
    public $lastTransferredAt;
    /**
     * @var bool True if the zone is active
     */
    public $active;
    /**
     * @var string When the zone was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the zone was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->accountId = $data->account_id;
        $this->name = $data->name;
        $this->reverse = $data->reverse;
        $this->secondary = $data->secondary;
        $this->lastTransferredAt = $data->last_transferred_at;
        $this->active = $data->active;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }

}
