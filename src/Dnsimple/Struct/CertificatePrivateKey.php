<?php


namespace Dnsimple\Struct;

/**
 * Represents a certificate private key in DNSimple
 * @package Dnsimple\Struct
 */
class CertificatePrivateKey
{
    /**
     * @var string The certificate private key
     */
    public $privateKey;

    public function __construct($data)
    {
        $this->privateKey = $data->private_key;
    }
}
