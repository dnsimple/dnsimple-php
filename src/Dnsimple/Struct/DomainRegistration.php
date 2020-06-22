<?php


namespace Dnsimple\Struct;

/**
 * Represents the result of a domain registration call.
 * @package Dnsimple\Struct
 */
class DomainRegistration
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
     * @var int The associated registrant (contact) ID
     */
    public int $registrantId;
    /**
     * @var int The number of years the domain was registered for
     */
    public int $period;
    /**
     * @var string The state of the renewal
     */
    public string $state;
    /**
     * @var bool True if the domain auto-renew was requested
     */
    public bool $autoRenew;
    /**
     * @var bool True if the domain WHOIS privacy was requested
     */
    public bool $whoisPrivacy;
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
        $this->registrantId = $data->registrant_id;
        $this->period = $data->period;
        $this->state = $data->state;
        $this->autoRenew = $data->auto_renew;
        $this->whoisPrivacy = $data->whois_privacy;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
