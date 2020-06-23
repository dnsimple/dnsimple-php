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
    public int $id;
    /**
     * @var int The associated domain ID
     */
    public int $domainId;
    /**
     * @var int The associated contact ID
     */
    public int $contactId;
    /**
     * @var string The certificate name
     */
    public string $name;
    /**
     * @var string The certificate common name
     */
    public string $commonName;
    /**
     * @var int The years the certificate will last
     */
    public int $years;
    /**
     * @var string The certificate CSR
     */
    public ?string $csr;
    /**
     * @var string The certificate state
     */
    public string $state;
    /**
     * @var bool True if the certificate is set to auto-renew on expiration
     */
    public bool $autoRenew;
    /**
     * @var array The certificate alternate names
     */
    public array $alternateNames;
    /**
     * @var string The Certificate Authority (CA) that issued the certificate
     */
    public string $authorityIdentifier;
    /**
     * @var string When the certificate was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the certificate was last updated in DNSimple
     */
    public string $updatedAt;
    /**
     * @var string When the certificate will expire
     */
    public ?string $expiresAt;

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
