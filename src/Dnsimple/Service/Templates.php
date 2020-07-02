<?php


namespace Dnsimple\Service;


use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Template;
use Dnsimple\Struct\TemplateRecord;

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
     * @param int $account The account id
     * @param array $options key/value options to sort and/or paginate the results
     * @return Response The templates in the account
     * @throws DnsimpleException When something goes wrong
     */
    public function listTemplates($account, array $options = []): Response
    {
        $response = $this->get("/{$account}/templates", $options);
        return new Response($response, Template::class);
    }

    /**
     * Creates a template in the account
     *
     * @see https://developer.dnsimple.com/v2/templates/#createTemplate
     *
     * @param int $account The account id
     * @param array $attributes The template attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created template
     * @throws DnsimpleException When something goes wrong
     */
    public function createTemplate($account, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/templates", $attributes);
        return new Response($response, Template::class);
    }

    /**
     * Gets the template with the specified id or sid
     *
     * @see https://developer.dnsimple.com/v2/templates/#getTemplate
     *
     * @param int $account The account id
     * @param int|string $template The template id or short name
     * @return Response The template requested
     * @throws DnsimpleException When something goes wrong
     */
    public function getTemplate($account, $template): Response
    {
        $response = $this->get("/{$account}/templates/{$template}");
        return new Response($response, Template::class);
    }

    /**
     * Updates a template with the provided data
     *
     * @see https://developer.dnsimple.com/v2/templates/#updateTemplate
     *
     * @param int $account The account id
     * @param int|string $template The template id or short name
     * @param array $attributes The template attributes. Refer to the documentation for the list of available fields.
     * @return Response The updated template
     * @throws DnsimpleException When something goes wrong
     */
    public function updateTemplate($account, $template, array $attributes = []): Response
    {
        $response = $this->patch("/{$account}/templates/{$template}", $attributes);
        return new Response($response, Template::class);
    }

    /**
     * Deletes a template from the account
     *
     * WARNING: This cannot be undone
     *
     * @see https://developer.dnsimple.com/v2/templates/#deleteTemplate
     *
     * @param int $account The account id
     * @param int|string $template The template id or short name
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function deleteTemplate($account, $template): Response
    {
        $response = $this->delete("/{$account}/templates/{$template}");
        return new Response($response);
    }

    /**
     * Lists the records in the template
     *
     * @see https://developer.dnsimple.com/v2/templates/records/#listTemplateRecords
     *
     * @param int $account The account id
     * @param int|string $template The template id or short name
     * @param array $options key/value options to sort and/or paginate the results
     * @return Response The list of template records
     * @throws DnsimpleException When something goes wrong
     */
    public function listTemplateRecords($account, $template, array $options = []): Response
    {
        $response = $this->get("/{$account}/templates/{$template}/records", $options);
        return new Response($response, TemplateRecord::class);
    }

    /**
     * Creates a record in the template
     *
     * @see https://developer.dnsimple.com/v2/templates/records/#createTemplateRecord
     *
     * @param int $account The account id
     * @param int|string $template The template id or short name
     * @param array $attributes The template record attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created template record
     * @throws DnsimpleException When something goes wrong
     */
    public function createTemplateRecord($account, $template, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/templates/{$template}/records", $attributes);
        return new Response($response, TemplateRecord::class);
    }

    /**
     * Gets a record from the template
     *
     * @see https://developer.dnsimple.com/v2/templates/records/#getTemplateRecord
     *
     * @param int $account The account id
     * @param int|string $template The template id or short name
     * @param int $record The record id
     * @return Response The template record
     * @throws DnsimpleException When something goes wrong
     */
    public function getTemplateRecord($account, $template, $record): Response
    {
        $response = $this->get("/{$account}/templates/{$template}/records/{$record}");
        return new Response($response, TemplateRecord::class);
    }

    /**
     * Deletes a record from the template.
     *
     * WARNING: this cannot be undone.
     *
     * @see https://developer.dnsimple.com/v2/templates/records/#deleteTemplateRecord
     *
     * @param int $account The account id
     * @param int|string $template The template id or short name
     * @param int $record The record id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function deleteTemplateRecord($account, $template, $record): Response
    {
        $response = $this->delete("/{$account}/templates/{$template}/records/{$record}");
        return new Response($response);
    }

    /**
     * Applies a template to the domain
     *
     * @see https://developer.dnsimple.com/v2/templates/domains/#applyTemplateToDomain
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int|string $template The template id or sid
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function applyTemplate($account, $domain, $template): Response
    {
        $response = $this->post("/{$account}/domains/{$domain}/templates/{$template}");
        return new Response($response);
    }
}
