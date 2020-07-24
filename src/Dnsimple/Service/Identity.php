<?php

namespace Dnsimple\Service;


use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Whoami;

/**
 * The Identity Service handles the identity (whoami) endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/identity/
 *
 * @package Dnsimple
 */
class Identity extends ClientService
{
    /**
     * Retrieves the details about the current authenticated entity used to access the API.
     *
     * @return  Response
     * @throws DnsimpleException When something goes wrong
     */
    public function whoami(): Response
    {
        $response = $this->get("/whoami");

        return new Response($response, Whoami::class);
    }
}
