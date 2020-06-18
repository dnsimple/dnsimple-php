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
    public int $id;
    /**
     * @var int The associated account ID in DNSimple
     */
    public int $accountId;
    /**
     * @var int|null The associated registrant (contact) ID in DNSimple
     */
    public ?int $registrantId;
    /**
     * @var string The domain name
     */
    public string $name;
    /**
     * @var string The domain unicode name
     */
    public string $unicodeName;
    /**
     * @var string The domain state
     */
    public string $state;
    /**
     * @var bool True if the domain is set to auto-renew, false otherwise
     */
    public bool $autoRenew;
    /**
     * @var bool True if the domain WHOIS privacy is enabled, false otherwise
     */
    public bool $privateWhois;
    /**
     * @var string|null The date the domain will expire
     */
    public ?string $expiresAt;
    /**
     * @var string When the domain was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the domain was last updated in DNSimple
     */
    public string $updatedAt;

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
        $this->expiresAt = $data->expires_at;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
