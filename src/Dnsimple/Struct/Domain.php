<?php


namespace Dnsimple\Struct;

/**
 * Represents a Domain.
 *
 * @see  https://developer.dnsimple.com/v2/domains/
 * @package Dnsimple\Struct
 */
class Domain
{
    /**
     * @var int The domain ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated account ID in DNSimple
     */
    public $accountId;
    /**
     * @var int|null The associated registrant (contact) ID in DNSimple
     */
    public $registrantId;
    /**
     * @var string The domain name
     */
    public $name;
    /**
     * @var string The domain unicode name
     */
    public $unicodeName;
    /**
     * @var string The domain state
     */
    public $state;
    /**
     * @var bool True if the domain is set to auto-renew, false otherwise
     */
    public $autoRenew;
    /**
     * @var bool True if the domain WHOIS privacy is enabled, false otherwise
     */
    public $privateWhois;
    /**
     * @var string|null The date the domain will expire
     */
    public $expiresOn;
    /**
     * @var string When the domain was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the domain was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->accountId = $data->account_id;
        $this->registrantId = $data->registrant_id;
        $this->name = $data->name;
        $this->unicodeName = $data->unicode_name;
        $this->state = $data->state;
        $this->autoRenew = $data->auto_renew;
        $this->privateWhois = $data->private_whois;
        $this->expiresOn = $data->expires_on;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
