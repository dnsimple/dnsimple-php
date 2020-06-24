<?php


namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Template;

/**
 * Handles communication with the templates related methods of the DNSimple API
 *
 * @see https://developer.dnsimple.com/v2/templates
 * @package Dnsimple\Service
 */
class Templates extends ClientService
{
    /**
     * Lists the templates in the account
     *
     * @see https://developer.dnsimple.com/v2/templates/#listTemplates
     *
     * @param int $accountId The account id
     * @param array $options key/value options to sort and/or paginate the results
     * @return Response The templates in the account
     */
    public function listTemplates($accountId, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/templates"), $options);
        return new Response($response, Template::class);
    }

    /**
     * Creates a template in the account
     *
     * @see https://developer.dnsimple.com/v2/templates/#createTemplate
     *
     * @param int $accountId The account id
     * @param array $attributes The template attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created template
     */
    public function createTemplate($accountId, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/templates"), $attributes);
        return new Response($response, Template::class);
    }

    /**
     * Gets the template with the specified id or sid
     *
     * @see https://developer.dnsimple.com/v2/templates/#getTemplate
     *
     * @param int $accountId The account id
     * @param int|string $template The template id or short name
     * @return Response The template requested
     */
    public function getTemplate($accountId, $template)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/templates/{$template}"));
        return new Response($response, Template::class);
    }

    /**
     * Updates a template with the provided data
     *
     * @see https://developer.dnsimple.com/v2/templates/#updateTemplate
     *
     * @param int $accountId The account id
     * @param int|string $template The template id or short name
     * @param array $attributes The template attributes. Refer to the documentation for the list of available fields.
     * @return Response The updated template
     */
    public function updateTemplate($accountId, $template, array $attributes = [])
    {
        $response = $this->client->patch(Client::versioned("/{$accountId}/templates/{$template}"), $attributes);
        return new Response($response, Template::class);
    }

    /**
     * Deletes a template from the account
     *
     * WARNING: This cannot be undone
     *
     * @see https://developer.dnsimple.com/v2/templates/#deleteTemplate
     *
     * @param int $accountId The account id
     * @param int|string $template The template id or short name
     * @return Response An empty response
     */
    public function deleteTemplate($accountId, $template)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/templates/{$template}"));
        return new Response($response);
    }
}
