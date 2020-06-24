<?php


namespace Dnsimple\Service;


use Dnsimple\Client;
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
     * @param int $accountId The account id
     * @param array $options key/value options to sort the results
     * @return Response The list of webhooks
     */
    public function listWebhooks($accountId, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/webhooks"), $options);
        return new Response($response, Webhook::class);
    }

    /**
     * Creates a webhook in the account
     *
     * @see https://developer.dnsimple.com/v2/webhooks/#createWebhook
     *
     * @param int $accountId The account id
     * @param array $attributes The webhook attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created webhook
     */
    public function createWebhook($accountId, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/webhooks"), $attributes);
        return new Response($response, Webhook::class);
    }

    /**
     * Gets a webhook from the account
     *
     * @see https://developer.dnsimple.com/v2/webhooks/#getWebhook
     *
     * @param int $accountId The account id
     * @param int $webhookId The webhook id
     * @return Response The webhook
     */
    public function getWebhook($accountId, $webhookId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/webhooks/{$webhookId}"));
        return new Response($response, Webhook::class);
    }

    /**
     * Deletes a webhook from the account
     *
     * @see https://developer.dnsimple.com/v2/webhooks/#deleteWebhook
     *
     * @param int $accountId The account id
     * @param int $webhookId The webhook id
     * @return Response An empty response
     */
    public function deleteWebhook($accountId, $webhookId)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/webhooks/{$webhookId}"));
        return new Response($response);
    }
}
