<?php


namespace Dnsimple\Struct;

/**
 * Represents a whois privacy in DNSimple
 * @package Dnsimple\Struct
 */
class WhoisPrivacy
{
    /**
     * @var int The whois privacy ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated domain ID
     */
    public $domainId;
    /**
     * @var string The date the whois privacy will expire on
     */
    public $expiresOn;
    /**
     * @var bool Whether the whois privacy is enabled for the domain
     */
    public $enabled;
    /**
     * @var string When the whois privacy was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the whois privacy was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->expiresOn = $data->expires_on;
        $this->enabled = $data->enabled;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
