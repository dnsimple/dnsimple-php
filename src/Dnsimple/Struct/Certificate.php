<?php


namespace Dnsimple\Struct;

/**
 * Represents a Certificate in DNSimple
 * @package Dnsimple\Struct
 */
class Certificate
{
    /**
     * @var int The certificate ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated domain ID
     */
    public $domainId;
    /**
     * @var int The associated contact ID
     */
    public $contactId;
    /**
     * @var string The certificate name
     */
    public $name;
    /**
     * @var string The certificate common name
     */
    public $commonName;
    /**
     * @var int The years the certificate will last
     */
    public $years;
    /**
     * @var string The certificate CSR
     */
    public $csr;
    /**
     * @var string The certificate state
     */
    public $state;
    /**
     * @var bool True if the certificate is set to auto-renew on expiration
     */
    public $autoRenew;
    /**
     * @var array The certificate alternate names
     */
    public $alternateNames;
    /**
     * @var string The Certificate Authority (CA) that issued the certificate
     */
    public $authorityIdentifier;
    /**
     * @var string When the certificate was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the certificate was last updated in DNSimple
     */
    public $updatedAt;
    /**
     * @var string When the certificate will expire
     */
    public $expiresAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->contactId = $data->contact_id;
        $this->name = $data->name;
        $this->commonName = $data->common_name;
        $this->years = $data->years;
        $this->csr = $data->csr;
        $this->state = $data->state;
        $this->autoRenew = $data->auto_renew;
        $this->alternateNames = $data->alternate_names;
        $this->authorityIdentifier = $data->authority_identifier;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
        $this->expiresAt = $data->expires_at;
    }
}
