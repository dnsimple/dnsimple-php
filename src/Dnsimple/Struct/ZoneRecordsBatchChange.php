<?php


namespace Dnsimple\Struct;

/**
 * Represents the result of a batch change of zone records
 * @package Dnsimple\Struct
 */
class ZoneRecordsBatchChange
{
    /**
     * @var array|ZoneRecord[] The created records
     */
    public $creates;
    /**
     * @var array|ZoneRecord[] The updated records
     */
    public $updates;
    /**
     * @var array|ZoneRecordId[] The IDs of the deleted records
     */
    public $deletes;

    public function __construct($data)
    {
        $this->creates = array_map(function($args) { return new ZoneRecord($args); }, $data->creates ?? []);
        $this->updates = array_map(function($args) { return new ZoneRecord($args); }, $data->updates ?? []);
        $this->deletes = array_map(function($args) { return new ZoneRecordId($args); }, $data->deletes ?? []);
    }
}
