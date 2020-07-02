<?php


namespace Dnsimple\Struct;

/**
 * Represents a zone record
 * @package Dnsimple\Struct
 */
class ZoneRecord
{
    /**
     * @var int The record ID in DNSimple
     */
    public $id;
    /**
     * @var string The associated zone ID in DNSimple
     */
    public $zoneId;
    /**
     * @var int|null The ID of the parent record, if this record is dependent on another record.
     */
    public $parentId;
    /**
     * @var string The record name (without the domain name)
     */
    public $name;
    /**
     * @var string The plain-text record content
     */
    public $content;
    /**
     * @var int The TTL value
     */
    public $ttl;
    /**
     * @var int|null The priority value, if the type of record accepts a priority
     */
    public $priority;
    /**
     * @var string The type of record, in uppercase
     */
    public $type;
    /**
     * @var array The regions where the record is propagated. This is optional
     */
    public $regions;
    /**
     * @var bool True if this is a system record created by DNSimple. System records are read-only.
     */
    public $systemRecord;
    /**
     * @var string When the record was created in DNSimple.
     */
    public $createdAt;
    /**
     * @var string When the record was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->zoneId = $data->zone_id;
        $this->parentId = $data->parent_id;
        $this->name = $data->name;
        $this->content = $data->content;
        $this->ttl = $data->ttl;
        $this->priority = $data->priority;
        $this->type = $data->type;
        $this->regions = $data->regions;
        $this->systemRecord = $data->system_record;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
