<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Charge;


// '/{account}/billing/charges':
//     get:
//       description: Lists the billing charges for the account.
//       parameters:
//         - $ref: '#/components/parameters/Account'
//         - $ref: '#/components/parameters/FilterStartDate'
//         - $ref: '#/components/parameters/FilterEndDate'
//         - $ref: '#/components/parameters/SortCharges'
//       operationId: listCharges
//       tags:
//         - billing
//       summary: List billing charges
//       responses:
//         '200':
//           content:
//             application/json:
//               schema:
//                 properties:
//                   data:
//                     type: array
//                     items:
//                       $ref: '#/components/schemas/Charge'
//                   pagination:
//                     $ref: '#/components/schemas/Pagination'
//                 type: object
//           description: Billing charges listing.
//         '401':
//           $ref: '#/components/responses/401'
//         '429':
//           $ref: '#/components/responses/429'

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
