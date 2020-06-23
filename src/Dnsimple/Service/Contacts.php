<?php


namespace Dnsimple\Service;


use Dnsimple\Client;
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
     * @param int $accountId The account id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of contacts
     */
    public function listContacts($accountId, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/contacts"), $options);
        return new Response($response, Contact::class);
    }

    /**
     * Creates a new contact in the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#createContact
     *
     * @param int $accountId The account id
     * @param array $attributes The contact attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created contact
     */
    public function createContact($accountId, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/contacts"), $attributes);
        return new Response($response, Contact::class);
    }

    /**
     * Gets a contact from the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#getContact
     *
     * @param int $accountId The account id
     * @param int $contactId The contact id
     * @return Response The contact
     */
    public function getContact($accountId, $contactId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/contacts/{$contactId}"));
        return new Response($response, Contact::class);
    }

    /**
     * Updates a contact in the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#updateContact
     *
     * @param int $accountId The account id
     * @param int $contactId The contact id
     * @param array $attributes The contact attributes. Refer to the documentation for the list of available fields.
     * @return Response The updated contact
     */
    public function updateContact($accountId, $contactId, array $attributes = [])
    {
        $response = $this->client->patch(Client::versioned("/{$accountId}/contacts/{$contactId}"), $attributes);
        return new Response($response, Contact::class);
    }

    /**
     * Deletes a contact from the account
     *
     * @see https://developer.dnsimple.com/v2/contacts/#deleteContact
     *
     * @param int $accountId The account id
     * @param int $contactId The contact id
     * @return Response An empty response
     */
    public function deleteContact($accountId, $contactId)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/contacts/{$contactId}"));
        return new Response($response);
    }
}
