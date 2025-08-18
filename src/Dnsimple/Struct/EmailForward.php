<?php


namespace Dnsimple\Struct;

/**
 * Represents an email forward in DNSimple
 * @package Dnsimple\Struct
 */
class EmailForward
{
    /**
     * @var int The email forward ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated domain ID
     */
    public $domainId;
    /**
     * @var string The "local part" of the originating email address. Anything to the left of the @ symbol
     * @deprecated
     */
    public $from;
    /**
     * @var string The full email address to forward to
     * @deprecated
     */
    public $to;
    /**
     * @var string The "local part" of the originating email address. Anything to the left of the @ symbol
     */
    public $aliasEmail;
    /**
     * @var string The full email address to forward to
     */
    public $destinationEmail;
    /**
     * @var bool Whether the email forward is active
     */
    public $active;
    /**
     * @var string When the email forward was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the email forward was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->from = $data->alias_email;
        $this->to = $data->destination_email;
        $this->aliasEmail = $data->alias_email;
        $this->destinationEmail = $data->destination_email;
        $this->active = $data->active;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
