<?php


namespace Dnsimple\Struct;

/**
 * Represents a TLD in DNSimple
 * @package Dnsimple\Struct
 */
class Tld
{
    /**
     * @var string The TLD in DNSimple
     */
    public string $tld;
    /**
     * @var int The TLD type
     */
    public int $tldType;
    /**
     * @var bool True if Whois Privacy Protection is available
     */
    public bool $whoisPrivacy;
    /**
     * @var bool True if TLD requires use of auto-renewal for renewals
     */
    public bool $autoRenewOnly;
    /**
     * @var bool True if IDN is available
     */
    public bool $idn;
    /**
     * @var int The minimum registration period in years
     */
    public int $minimumRegistration;
    /**
     * @var bool True if DNSimple supports registrations for this TLD
     */
    public bool $registrationEnabled;
    /**
     * @var bool True if DNSimple supports renewals for this TLD
     */
    public bool $renewalEnabled;
    /**
     * @var bool True if DNSimple supports inbound transfers for this TLD
     */
    public bool $transferEnabled;

    public function __construct($data)
    {
        $this->tld = $data->tld;
        $this->tldType = $data->tld_type;
        $this->whoisPrivacy = $data->whois_privacy;
        $this->autoRenewOnly = $data->auto_renew_only;
        $this->idn = $data->idn;
        $this->minimumRegistration = $data->minimum_registration;
        $this->registrationEnabled = $data->registration_enabled;
        $this->renewalEnabled = $data->renewal_enabled;
        $this->transferEnabled = $data->transfer_enabled;
    }
}
