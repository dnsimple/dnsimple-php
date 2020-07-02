<?php


namespace Dnsimple\Struct;

/**
 * Represents a certificate purchase in DNSimple
 * @package Dnsimple\Struct
 */
class CertificatePurchase
{
    /**
     * @var int The certificate purchase ID in DNSimple
     */
    public $id;
    /**
     * @var int The certificate ID
     */
    public $certificateId;
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
        $this->certificateId = $data->certificate_id;
        $this->state = $data->state;
        $this->autoRenew = $data->auto_renew;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
