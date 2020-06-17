<?php


namespace Dnsimple;

use Dnsimple\Struct\Account;

/**
 * Lists the accounts the authenticated entity has access to.
 *
 * @see http://developer.dnsimple.com/v2/accounts
 * @package Dnsimple
 */
class AccountsService extends ClientService
{

    /**
     * Lists the accounts the current authenticated entity has access to.
     *
     * @return Response The response containing the list of accounts
     */
    function listAccounts(): Response
    {
        $response = $this->client->get(Client::versioned("/accounts"));
        return new Response($response, Account::class);
    }
}