<?php


namespace Dnsimple\Struct;


class Dnssec
{
    public $enabled;
    public $createdAt;
    public $updatedAt;

    public function __construct($data)
    {
        $this->enabled = $data->enabled;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
