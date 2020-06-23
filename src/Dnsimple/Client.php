<?php

namespace Dnsimple;

use Dnsimple\Service\AccountsService;
use Dnsimple\Service\DomainsService;
use Dnsimple\Service\IdentityService;
use Dnsimple\Service\OauthService;
use Dnsimple\Service\RegistrarService;
use Dnsimple\Service\ZonesService;
use GuzzleHttp;

/**
 * The version of this Dnsimple client library.
 *
 * @see http://semver.org/ This project uses Semantic Versioning 2.0.0
 */
const VERSION = "0.1.0-dev";


/**
 * PHP Client for the DNSimple API
 *
 * You can use this service to consume the services the DNSimple API offers. All requests have to be done authenticated.
 * You can either use basic authentication (email and password combination) or an oauth token
 * (see https://developer.dnsimple.com/v2/oauth/).
 *
 * For more information on how to use the DNSimple API refer to https://developer.dnsimple.com
 */
class Client
{
    /**
     * The current API version.
     */
    const API_VERSION = "v2";

    /**
     * URL to the production environment
     */
    const BASE_URL = "https://api.dnsimple.com";


    /**
     * @var string $accessToken the bearer authentication token
     */
    private string $accessToken;

    /**
     * The http client we are using to send requests to the DNSimple API.
     *
     * @var GuzzleHttp\Client $httpClient the HTTP client
     */
    private GuzzleHttp\Client $httpClient;

    /**
     * @var IdentityService The service handling the Identity API
     */
    public IdentityService $Identity;
    /**
     * @var AccountsService The service handling the Accounts API
     */
    public AccountsService $Accounts;
    /**
     * @var DomainsService The service handling the Domains API
     */
    public DomainsService $Domains;
    /**
     * @var RegistrarService The service handling the Registrar API
     */
    private RegistrarService $Registrar;
    /**
     * @var ZonesService The service handling the Zones API
     */
    private ZonesService $Zones;
    /**
     * @var OauthService The service handling the Oauth API
     */
    private OauthService $Oauth;

    public function __construct($accessToken, array $config = array())
    {
        $this->accessToken = $accessToken;
        $this->httpClient = new GuzzleHttp\Client(
            array_merge(["base_uri" => self::BASE_URL], $config)
        );
        $this->attachServicesToClient();
    }

    /**
     * Prepends the current API version to $path, and returns the value.
     *
     * @param  string $path
     * @return string the versioned path
     */
    public static function versioned($path)
    {
        return "/" . self::API_VERSION . $path;
    }

    public function get($path, array $options = [])
    {
        $query = ["query" => $options];

        return $this->request("GET", $path, $query);
    }

    public function post($path, array $options = [])
    {
        return $this->request("POST", $path, $options);
    }

    public function delete($path, array $options = [])
    {
        return $this->request("DELETE", $path, $options);
    }

    public function patch($path, array $options = [])
    {
        return $this->request("PATCH", $path, $options);
    }

    public function put($path, array $options = [])
    {
        return $this->request("PUT", $path, $options);
    }

    public function request($method, $path, array $options = [])
    {
        $requestOptions = array_merge_recursive($options, [
            "headers" => [
                "Authorization" => "Bearer $this->accessToken",
                "Accept" => "application/json",
                "User-Agent" => $this->getUserAgent(),
            ]
        ]);

        try {
            return $this->httpClient->request($method, $path, $requestOptions);
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            throw new DnsimpleException($e);
        }
    }

    public function getUserAgent(): string
    {
        return "dnsimple-php/" . VERSION;
    }

    private function attachServicesToClient()
    {
        $this->Accounts = new AccountsService($this);
        $this->Domains = new DomainsService($this);
        $this->Identity = new IdentityService($this);
        $this->Oauth = new OauthService($this);
        $this->Registrar = new RegistrarService($this);
        $this->Zones = new ZonesService($this);
    }
}
