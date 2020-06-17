<?php

namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Whoami;

/**
 * The Identity Service handles the identity (whoami) endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/identity/
 *
 * @package Dnsimple
 */
class IdentityService extends ClientService
{
    /**
     * Retrieves the details about the current authenticated entity used to access the API.
     *
     * @return  Response
     */
    public function whoami(): Response
    {
        $response = $this->client->get(Client::versioned("/whoami"));

        return new Response($response, Whoami::class);
    }
}
