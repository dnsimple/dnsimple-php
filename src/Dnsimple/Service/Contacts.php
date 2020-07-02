<?php


namespace Dnsimple\Service;


use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Contact;

/**
 * Handles communication with the contact related methods of the DNSimple API
 *
 * @see https://developer.dnsimple.com/v2/contacts/
 * @package Dnsimple\Service
 */
class Contacts extends ClientService
{
    /**
     * Lists the contacts in the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#listContacts
     *
     * @param int $account The account id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of contacts
     * @throws DnsimpleException When something goes wrong
     */
    public function listContacts($account, array $options = []): Response
    {
        $response = $this->get("/{$account}/contacts", $options);
        return new Response($response, Contact::class);
    }

    /**
     * Creates a new contact in the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#createContact
     *
     * @param int $account The account id
     * @param array $attributes The contact attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created contact
     * @throws DnsimpleException When something goes wrong
     */
    public function createContact($account, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/contacts", $attributes);
        return new Response($response, Contact::class);
    }

    /**
     * Gets a contact from the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#getContact
     *
     * @param int $account The account id
     * @param int $contact The contact id
     * @return Response The contact
     * @throws DnsimpleException When something goes wrong
     */
    public function getContact($account, $contact): Response
    {
        $response = $this->get("/{$account}/contacts/{$contact}");
        return new Response($response, Contact::class);
    }

    /**
     * Updates a contact in the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#updateContact
     *
     * @param int $account The account id
     * @param int $contact The contact id
     * @param array $attributes The contact attributes. Refer to the documentation for the list of available fields.
     * @return Response The updated contact
     * @throws DnsimpleException When something goes wrong
     */
    public function updateContact($account, $contact, array $attributes = []): Response
    {
        $response = $this->patch("/{$account}/contacts/{$contact}", $attributes);
        return new Response($response, Contact::class);
    }

    /**
     * Deletes a contact from the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#deleteContact
     *
     * @param int $account The account id
     * @param int $contact The contact id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function deleteContact($account, $contact): Response
    {
        $response = $this->delete("/{$account}/contacts/{$contact}");
        return new Response($response);
    }
}
