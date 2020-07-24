<?php


namespace Dnsimple\Struct;

/**
 * Represents a user
 *
 * @see https://developer.dnsimple.com/v2/identity/
 * @package Dnsimple\Struct
 */
class User
{
    /**
     * @var int The ID of the user in DNSimple
     */
    public $id;
    /**
     * @var string The users email
     */
    public $email;
    /**
     * @var string When the user was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the user was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->email = $data->email;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
