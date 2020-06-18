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
    public int $id;
    /**
     * @var int The associated account ID in DNSimple
     */
    public int $accountId;
    /**
     * @var string The zone name
     */
    public string $name;
    /**
     * @var bool True if the zone is a reverse zone
     */
    public bool $reverse;
    /**
     * @var string When the zone was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the zone was last updated in DNSimple
     */
    public string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->accountId = $data->account_id;
        $this->name = $data->name;
        $this->reverse = $data->reverse;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }

}
