<?php


namespace Dnsimple\Struct;

/**
 * Represents the ID of a zone record
 * @package Dnsimple\Struct
 */
class ZoneRecordId
{
    /**
     * @var int The record ID in DNSimple
     */
    public $id;

    public function __construct($data)
    {
        $this->id = $data->id;
    }
}
