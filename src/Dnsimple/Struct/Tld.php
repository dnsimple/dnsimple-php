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
    public $tld;
    /**
     * @var int The TLD type
     */
    public $tldType;
    /**
     * @var bool True if Whois Privacy Protection is available
     */
    public $whoisPrivacy;
    /**
     * @var bool True if TLD requires use of auto-renewal for renewals
     */
    public $autoRenewOnly;
    /**
     * @var bool True if IDN is available
     */
    public $idn;
    /**
     * @var int The minimum registration period in years
     */
    public $minimumRegistration;
    /**
     * @var bool True if DNSimple supports registrations for this TLD
     */
    public $registrationEnabled;
    /**
     * @var bool True if DNSimple supports renewals for this TLD
     */
    public $renewalEnabled;
    /**
     * @var bool True if DNSimple supports inbound transfers for this TLD
     */
    public $transferEnabled;

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
