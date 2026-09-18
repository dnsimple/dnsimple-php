<?php


namespace Dnsimple\Struct;

/**
 * Represents a domain restore
 * @package Dnsimple\Struct
 */
class DomainRestore
{
    /**
     * @var int The domain restore ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated domain ID
     */
    public $domainId;
    /**
     * @var string The state of the restore
     */
    public $state;
    /**
     * @var string When the domain restore was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the domain restore was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->state = $data->state;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
