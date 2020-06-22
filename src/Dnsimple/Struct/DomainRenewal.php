<?php


namespace Dnsimple\Struct;

/**
 * Represents a domain renewal
 * @package Dnsimple\Struct
 */
class DomainRenewal
{
    /**
     * @var int The domain registration ID in DNSimple
     */
    public int $id;
    /**
     * @var int The associated domain ID
     */
    public int $domainId;
    /**
     * @var int The number of years the domain was registered for
     */
    public int $period;
    /**
     * @var string The state of the renewal
     */
    public string $state;
    /**
     * @var string When the domain renewal was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the domain renewal was last updated in DNSimple
     */
    public string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->period = $data->period;
        $this->state = $data->state;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
