<?php


namespace Dnsimple\Struct;

/**
 * Represents an Account.
 *
 * @see https://developer.dnsimple.com/v2/identity/
 * @package Dnsimple\Struct
 */
class Account
{
    /**
     * @var int The account ID in DNSimple
     */
    public $id;
    /**
     * @var string The account email
     */
    public $email;
    /**
     * @var string The identifier of the plan the account is subscribed to
     */
    public $planIdentifier;
    /**
     * @var string When the account was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the account was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->email = $data->email;
        $this->planIdentifier = $data->plan_identifier;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
