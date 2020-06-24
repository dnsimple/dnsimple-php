<?php

namespace Dnsimple;

use Dnsimple\Service\Accounts;
use Dnsimple\Service\Domains;
use Dnsimple\Service\Identity;
use Dnsimple\Service\Oauth;
use Dnsimple\Service\Registrar;
use Dnsimple\Service\Services;
use Dnsimple\Service\Templates;
use Dnsimple\Service\Tlds;
use Dnsimple\Service\VanityNameServers;
use Dnsimple\Service\Zones;
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
     * @var Identity The service handling the Identity API
     */
    public Identity $Identity;
    /**
     * @var Accounts The service handling the Accounts API
     */
    public Accounts $Accounts;
    /**
     * @var Domains The service handling the Domains API
     */
    public Domains $Domains;
    /**
     * @var Registrar The service handling the Registrar API
     */
    public Registrar $Registrar;
    /**
     * @var Zones The service handling the Zones API
     */
    public Zones $Zones;
    /**
     * @var Oauth The service handling the Oauth API
     */
    public Oauth $Oauth;
    /**
     * @var Tlds The service handling the Tlds API
     */
    public Tlds $Tlds;
    /**
     * @var Services The service handling the Services API
     */
    public Services $Services;
    /**
     * @var Templates The service handling the Templates API
     */
    public Templates $Templates;
    /**
     * @var VanityNameServers The service handling the Vanity Name Servers API
     */
    public VanityNameServers $VanityNameServers;

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
        $this->Accounts = new Accounts($this);
        $this->Domains = new Domains($this);
        $this->Identity = new Identity($this);
        $this->Oauth = new Oauth($this);
        $this->Registrar = new Registrar($this);
        $this->Services = new Services($this);
        $this->Templates = new Templates($this);
        $this->Tlds = new Tlds($this);
        $this->VanityNameServers = new VanityNameServers($this);
        $this->Zones = new Zones($this);
    }
}
