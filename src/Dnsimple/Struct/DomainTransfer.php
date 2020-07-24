<?php


namespace Dnsimple\Struct;

/**
 * Represents the result of a domain transfer call
 * @package Dnsimple\Struct
 */
class DomainTransfer
{
    /**
     * @var int The domain transfer ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated domain ID
     */
    public $domainId;
    /**
     * @var int The associated registrant (contact) ID
     */
    public $registrantId;
    /**
     * @var string The state of the renewal
     */
    public $state;
    /**
     * @var bool True if the domain auto-renew was requested
     */
    public $autoRenew;
    /**
     * @var bool True if the domain WHOIS privacy was requested
     */
    public $whoisPrivacy;

    public $statusDescription;
    /**
     * @var string When the domain transfer was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the domain renewal was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id= $data->id;
        $this->domainId = $data->domain_id;
        $this->registrantId = $data->registrant_id;
        $this->state = $data->state;
        $this->autoRenew = $data->auto_renew;
        $this->whoisPrivacy = $data->whois_privacy;
        if (property_exists($data, 'status_description'))
            $this->statusDescription = $data->status_description;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
