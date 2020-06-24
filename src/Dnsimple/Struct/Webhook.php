<?php


namespace Dnsimple\Struct;

/**
 * Represents a DNSimple webhook
 * @package Dnsimple\Struct
 */
class Webhook
{
    /**
     * @var int The webhook ID in DNSimple
     */
    public int $id;
    /**
     * @var string The callback URL
     */
    public string $url;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->url = $data->url;
    }
}
