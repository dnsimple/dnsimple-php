<?php


namespace Dnsimple\Struct;

/**
 * Represents the structure holding a User and Account object.
 *
 * @see https://developer.dnsimple.com/v2/identity/
 * @package Dnsimple\Struct
 */
class Whoami
{
    /**
     * @var Account The account, if present
     */
    public $account;
    /**
     * @var User The user, if present
     */
    public $user;

    public function __construct($data)
    {
        $account_data = $data->account;
        $user_data = $data->user;

        if (is_object($account_data))
            $this->account = new Account($account_data);
        if (is_object($user_data))
            $this->user = new User($user_data);
    }

}
