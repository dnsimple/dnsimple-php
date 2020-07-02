<?php


namespace Dnsimple\Struct;

/**
 * AccessToken represents a DNSimple Oauth access token.
 *
 * @see https://developer.dnsimple.com/v2/oauth/
 * @package Dnsimple\Struct
 */
class AccessToken
{
    /**
     * @var int The account ID in DNSimple this token belongs to
     */
    public $accountId;
    /**
     * @var string The token type
     */
    public $tokenType;
    /**
     * @var string The token you can use to authenticate
     */
    public $accessToken;
    /**
     * @var string|null The token scope (not used for now)
     */
    public $scope;

    public function __construct($data)
    {
        $this->accountId = $data->account_id;
        $this->tokenType = $data->token_type;
        $this->accessToken = $data->access_token;
        $this->scope = $data->scope;
    }
}
