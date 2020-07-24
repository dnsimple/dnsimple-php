<?php


namespace Dnsimple\Struct;

/**
 * Represents a Certificate Renewal in DNSimple
 * @package Dnsimple\Struct
 */
class CertificateRenewal
{
    /**
     * @var int The certificate renewal ID in DNSimple
     */
    public $id;
    /**
     * @var int The old certificate ID
     */
    public $oldCertificateId;
    /**
     * @var int The new certificate ID
     */
    public $newCertificateId;
    /**
     * @var string The certificate renewal state
     */
    public $state;
    /**
     * @var bool True if the certificate is requested to auto-renew
     */
    public $autoRenew;
    /**
     * @var string When the certificate renewal was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the certificate renewal was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->oldCertificateId = $data->old_certificate_id;
        $this->newCertificateId = $data->new_certificate_id;
        $this->state = $data->state;
        $this->autoRenew = $data->auto_renew;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
