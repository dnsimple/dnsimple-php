<?php


namespace Dnsimple\Struct;

/**
 * Represents a certificate download in DNSimple
 * @package Dnsimple\Struct
 */
class CertificateDownload
{
    /**
     * @var string The server certificate
     */
    public string $server;
    /**
     * @var string|null The root certificate
     */
    public ?string $root;
    /**
     * @var array The intermediate certificates
     */
    public array $chain;

    public function __construct($data)
    {
        $this->server = $data->server;
        $this->root = $data->root;
        $this->chain = $data->chain;
    }
}
