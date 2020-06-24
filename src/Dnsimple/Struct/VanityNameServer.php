<?php


namespace Dnsimple\Struct;

/**
 * Represents a vanity name server in DNSimple
 * @package Dnsimple\Struct
 */
class VanityNameServer
{
    /**
     * @var int The vanity name server ID in DNSimple
     */
    public int $id;
    /**
     * @var string The vanity name server name
     */
    public string $name;
    /**
     * @var string he vanity name server IPv4
     */
    public string $ipv4;
    /**
     * @var string The vanity name server IPv6
     */
    public string $ipv6;
    /**
     * @var string When the vanity name server was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the vanity name server was last updated in DNSimple
     */
    public string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->ipv4 = $data->ipv4;
        $this->ipv6 = $data->ipv6;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
