<?php


namespace Dnsimple\Service;


use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Webhook;

/**
 * Handles communication with the webhook related methods of the DNSimple API
 * @package Dnsimple\Service
 */
class Webhooks extends ClientService
{
    /**
     * List the webhooks in the account
     *
     * @see https://developer.dnsimple.com/v2/webhooks/#listWebhooks
     *
     * @param int $account The account id
     * @param array $options key/value options to sort the results
     * @return Response The list of webhooks
     * @throws DnsimpleException When something goes wrong
     */
    public function listWebhooks($account, array $options = []): Response
    {
        $response = $this->get("/{$account}/webhooks", $options);
        return new Response($response, Webhook::class);
    }

    /**
     * Creates a webhook in the account
     *
     * @see https://developer.dnsimple.com/v2/webhooks/#createWebhook
     *
     * @param int $account The account id
     * @param array $attributes The webhook attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created webhook
     * @throws DnsimpleException When something goes wrong
     */
    public function createWebhook($account, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/webhooks", $attributes);
        return new Response($response, Webhook::class);
    }

    /**
     * Gets a webhook from the account
     *
     * @see https://developer.dnsimple.com/v2/webhooks/#getWebhook
     *
     * @param int $account The account id
     * @param int $webhook The webhook id
     * @return Response The webhook
     * @throws DnsimpleException When something goes wrong
     */
    public function getWebhook($account, $webhook): Response
    {
        $response = $this->get("/{$account}/webhooks/{$webhook}");
        return new Response($response, Webhook::class);
    }

    /**
     * Deletes a webhook from the account
     *
     * @see https://developer.dnsimple.com/v2/webhooks/#deleteWebhook
     *
     * @param int $account The account id
     * @param int $webhook The webhook id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function deleteWebhook($account, $webhook): Response
    {
        $response = $this->delete("/{$account}/webhooks/{$webhook}");
        return new Response($response);
    }
}
