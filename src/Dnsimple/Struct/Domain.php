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
    public int $account_id;
    /**
     * @var int|null The associated registrant (contact) ID in DNSimple
     */
    public ?int $registrant_id;
    /**
     * @var string The domain name
     */
    public string $name;
    /**
     * @var string The domain unicode name
     */
    public string $unicode_name;
    /**
     * @var string The domain state
     */
    public string $state;
    /**
     * @var bool True if the domain is set to auto-renew, false otherwise
     */
    public bool $auto_renew;
    /**
     * @var bool True if the domain WHOIS privacy is enabled, false otherwise
     */
    public bool $private_whois;
    /**
     * @var string|null The date the domain will expire
     */
    public ?string $expires_at;
    /**
     * @var string When the domain was created in DNSimple
     */
    public string $created_at;
    /**
     * @var string When the domain was last updated in DNSimple
     */
    public string $updated_at;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->account_id = $data->account_id;
        $this->registrant_id = $data->registrant_id;
        $this->name = $data->name;
        $this->unicode_name = $data->unicode_name;
        $this->state = $data->state;
        $this->auto_renew = $data->auto_renew;
        $this->private_whois = $data->private_whois;
        $this->expires_at = $data->expires_at;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
    }
}
