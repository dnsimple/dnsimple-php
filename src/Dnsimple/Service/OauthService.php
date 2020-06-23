<?php


namespace Dnsimple\Service;

use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\AccessToken;
use function GuzzleHttp\Psr7\build_query;

/**
 * The Registrar Service handles the oauth endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/oauth
 * @package Dnsimple
 */
class OauthService extends ClientService
{
    /**
     * Exchange the short-lived authorization code for an access token you can use to authenticate your API calls.
     *
     * @see https://developer.dnsimple.com/v2/oauth/
     *
     * @param array $attributes key/value options.
     * @return Response The access token
     */
    public function exchangeAuthorizationForToken(array $attributes=[])
    {
        $attributes["grant_type"] = "authorization_code";
        $response = $this->client->post("/oauth/access_token", $attributes);
        return new Response($response, AccessToken::class);
    }

    /**
     * Generates the URL to authorize an user for an application via the OAuth2 flow
     *
     * @see https://developer.dnsimple.com/v2/oauth/
     *
     * @param string $clientId The service ID you received from DNSimple when you registered the application
     * @param array $attributes key/value options to help build the url
     * @return string The URL to redirect the user to authorize
     */
    public function authorizeUrl($clientId, array $attributes = [])
    {
        return rtrim(Client::BASE_URL . "/oauth/authorize?client_id={$clientId}&response_type=code&" . build_query($attributes), "&");
    }
}
