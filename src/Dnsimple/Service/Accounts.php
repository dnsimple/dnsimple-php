<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Account;

/**
 * Lists the accounts the authenticated entity has access to.
 *
 * @see http://developer.dnsimple.com/v2/accounts
 * @package Dnsimple
 */
class Accounts extends ClientService
{

    /**
     * Lists the accounts the current authenticated entity has access to.
     *
     * @see https://developer.dnsimple.com/v2/accounts/#listAccounts
     *
     * @return Response The response containing the list of accounts
     */
    function listAccounts(): Response
    {
        $response = $this->get("/accounts");
        return new Response($response, Account::class);
    }
}
