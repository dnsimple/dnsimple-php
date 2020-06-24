<?php


namespace Dnsimple\Struct;

/**
 * Represents a template in DNSimple
 * @package Dnsimple\Struct
 */
class Template
{
    /**
     * @var int The template ID in DNSimple
     */
    public int $id;
    /**
     * @var int The associated account ID
     */
    public int $accountId;
    /**
     * @var string The template name
     */
    public string $name;
    /**
     * @var string The string ID for the template
     */
    public string $sid;
    /**
     * @var string The template description
     */
    public string $description;
    /**
     * @var string When the template was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the template was last updated in DNSimple
     */
    public string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->accountId = $data->account_id;
        $this->name = $data->name;
        $this->sid = $data->sid;
        $this->description = $data->description;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
