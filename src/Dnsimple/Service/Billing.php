<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Charge;

/**
 * Lists the billing charges the authenticated entity has access to.
 *
 * @see http://developer.dnsimple.com/v2/billing
 * @package Dnsimple
 */
class Billing extends ClientService
{

    /**
     * Lists the billing charges the current authenticated entity has access to.
     *
     * @see https://developer.dnsimple.com/v2/billing/#listCharges
     *
     * @return Response The response containing the list of charges
     * @throws DnsimpleException When something goes wrong
     */
    function listCharges($account, array $options = []): Response
    {
        $response = $this->get("/{$account}/billing/charges", $options);
        return new Response($response, Charge::class);
    }
}
