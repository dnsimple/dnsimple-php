<?php


namespace Dnsimple\Service;


use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Tld;
use Dnsimple\Struct\TldExtendedAttribute;

/**
 * Handles communication with the Tld related methods of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/tlds
 * @package Dnsimple\Service
 */
class Tlds extends ClientService
{
    /**
     * Lists the TLDs available for registration
     *
     * @see https://developer.dnsimple.com/v2/tlds/#listTlds
     *
     * @param array $options key/value options to sort and filter the results
     * @return Response The tld list
     * @throws DnsimpleException When something goes wrong
     */
    public function listTlds(array $options = []): Response
    {
        $response = $this->get("/tlds", $options);
        return new Response($response, Tld::class);
    }

    /**
     * Gets the details of a TLD
     *
     * @see https://developer.dnsimple.com/v2/tlds/#getTld
     *
     * @param string $tld The TLD name
     * @return Response The TLD details
     * @throws DnsimpleException When something goes wrong
     */
    public function getTld($tld): Response
    {
        $response = $this->get("/tlds/{$tld}");
        return new Response($response, Tld::class);
    }

    /**
     * Gets the extended attributes for a TLD
     *
     * @see https://developer.dnsimple.com/v2/tlds/#getTldExtendedAttributes
     *
     * @param string $tld The TLD name
     * @return Response The TLDs extended attributes
     * @throws DnsimpleException When something goes wrong
     */
    public function getTldExtendedAttributes($tld): Response
    {
        $response = $this->get("/tlds/{$tld}/extended_attributes");
        return new Response($response, TldExtendedAttribute::class);
    }
}
