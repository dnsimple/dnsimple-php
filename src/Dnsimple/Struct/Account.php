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
    public string $plan_identifier;
    /**
     * @var string When the account was created in DNSimple
     */
    public string $created_at;
    /**
     * @var string When the account was last updated in DNSimple
     */
    public string $updated_at;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->email = $data->email;
        $this->plan_identifier = $data->plan_identifier;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
    }
}
