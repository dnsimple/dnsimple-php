<?php


namespace Dnsimple\Service;


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
     */
    public function listContacts($account, array $options = [])
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
     */
    public function createContact($account, array $attributes = [])
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
     */
    public function getContact($account, $contact)
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
     */
    public function updateContact($account, $contact, array $attributes = [])
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
     */
    public function deleteContact($account, $contact)
    {
        $response = $this->delete("/{$account}/contacts/{$contact}");
        return new Response($response);
    }
}
