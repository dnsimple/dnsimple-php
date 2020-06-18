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
    public int $id;
    /**
     * @var string The account email
     */
    public string $email;
    /**
     * @var string The identifier of the plan the account is subscribed to
     */
    public string $planIdentifier;
    /**
     * @var string When the account was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the account was last updated in DNSimple
     */
    public string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->email = $data->email;
        $this->planIdentifier = $data->plan_identifier;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
