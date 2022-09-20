<?php

namespace Dnsimple;

use Dnsimple\Exceptions\HttpException;
use Dnsimple\Exceptions\BadRequestException;
use Dnsimple\Exceptions\NotFoundException;
use Dnsimple\Service\Accounts;
use Dnsimple\Service\Certificates;
use Dnsimple\Service\Contacts;
use Dnsimple\Service\Domains;
use Dnsimple\Service\Identity;
use Dnsimple\Service\Oauth;
use Dnsimple\Service\Registrar;
use Dnsimple\Service\Services;
use Dnsimple\Service\Templates;
use Dnsimple\Service\Tlds;
use Dnsimple\Service\VanityNameServers;
use Dnsimple\Service\Webhooks;
use Dnsimple\Service\Zones;
use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * The version of this Dnsimple client library.
 *
 * @see http://semver.org/ This project uses Semantic Versioning 2.0.0
 */
const VERSION = "1.0.0";


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
     * The current API version
     */
    const API_VERSION = "v2";

    /**
     * URL to the production environment
     */
    const BASE_URL = "https://api.dnsimple.com";
    /**
     * The default user agent
     */
    const DEFAULT_USER_AGENT = "dnsimple-php/" . VERSION;


    /**
     * @var string $accessToken the bearer authentication token
     */
    private $accessToken;

    /**
     * @var string $customUserAgent a custom user agent name
     */
    private $customUserAgent = "";

    /**
     * The http client we are using to send requests to the DNSimple API.
     *
     * @var GuzzleHttp\Client $httpClient the HTTP client
     */
    private $httpClient;

    /**
     * @var Identity The service handling the Identity API
     */
    public $identity;
    /**
     * @var Accounts The service handling the Accounts API
     */
    public $accounts;
    /**
     * @var Domains The service handling the Domains API
     */
    public $domains;
    /**
     * @var Registrar The service handling the Registrar API
     */
    public $registrar;
    /**
     * @var Zones The service handling the Zones API
     */
    public $zones;
    /**
     * @var Oauth The service handling the Oauth API
     */
    public $oauth;
    /**
     * @var Tlds The service handling the Tlds API
     */
    public $tlds;
    /**
     * @var Services The service handling the Services API
     */
    public $services;
    /**
     * @var Templates The service handling the Templates API
     */
    public $templates;
    /**
     * @var VanityNameServers The service handling the Vanity Name Servers API
     */
    public $vanityNameServers;
    /**
     * @var Webhooks The service handling the Webhooks API
     */
    public $webhooks;
    /**
     * @var Certificates The service handling the Certificates API
     */
    public $certificates;
    /**
     * @var Contacts The service handling the Contacts API
     */
    public $contacts;

    /**
     * Client constructor.
     * @param string $accessToken The OAuth access token
     * @param array $config Configuration options passed to the client (such as the base_uri, etc)
     */
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
    public static function versioned($path): string
    {
        return "/" . self::API_VERSION . $path;
    }

    /**
     * Sends a GET request to the DNSimple API
     *
     * @param string $path The path to the service
     * @param array $options Any extra options passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    public function get($path, array $options = []): ResponseInterface
    {
        $query = ["query" => $options];

        return $this->request("GET", $path, $query);
    }

    /**
     * Sends a POST request to the DNSimple API
     *
     * @param string $path The path to the service
     * @param array $options Any extra options passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    public function post($path, array $options = []): ResponseInterface
    {
        return $this->request("POST", $path, $options);
    }

    /**
     * Sends a DELETE request to the DNSimple API
     *
     * @param string $path The path to the service
     * @param array $options Any extra options passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    public function delete($path, array $options = []): ResponseInterface
    {
        return $this->request("DELETE", $path, $options);
    }

    /**
     * Sends a PATCH request to the DNSimple API
     *
     * @param string $path The path to the service
     * @param array $options Any extra options passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    public function patch($path, array $options = []): ResponseInterface
    {
        return $this->request("PATCH", $path, $options);
    }

    /**
     * Sends a PUT request to the DNSimple API
     *
     * @param string $path The path to the service
     * @param array $options Any extra options passed with the request
     * @return ResponseInterface The raw response from the server
     * @throws DnsimpleException When something goes wrong
     */
    public function put($path, array $options = []): ResponseInterface
    {
        return $this->request("PUT", $path, $options);
    }

    /**
     * Sends a request to the DNSimple API
     *
     * @param string $method The HTTP method (GET, POST, PUT, PATCH, DELETE)
     * @param string $path The path to the service
     * @param array $options Any extra options passed with the request
     * @return ResponseInterface
     * @throws DnsimpleException
     */
    public function request($method, $path, array $options = []): ResponseInterface
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
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $exception_map = [
                400 => BadRequestException::class,
                404 => NotFoundException::class,
            ];
            $response = $e->getResponse();

            if (array_key_exists($response->getStatusCode(), $exception_map)) {
                $exceptionClass = $exception_map[$response->getStatusCode()];
            } else {
                $exceptionClass = HttpException::class;
            }
            $exception = $exceptionClass::fromResponse($response);
            throw $exception;
        } catch (GuzzleException $e) {
            throw new DnsimpleException($e);
        }
    }

    /**
     * Returns the user agent
     *
     * @return string The user Agent
     */
    public function getUserAgent(): string
    {
        return trim($this->customUserAgent . " " . self::DEFAULT_USER_AGENT);
    }

    /**
     * Adds a custom name to the user agent sent to the DNSimple API
     *
     * @example setUserAgent("My Super App") would result in the user agent "My Super app dnsimple-php/CURRENT_VERSION
     * @param string $customName The custom name you want to use
     */
    public function setUserAgent($customName): void
    {
        $this->customUserAgent = $customName;
    }

    private function attachServicesToClient(): void
    {
        $this->accounts = new Accounts($this);
        $this->certificates = new Certificates($this);
        $this->contacts = new Contacts($this);
        $this->domains = new Domains($this);
        $this->identity = new Identity($this);
        $this->oauth = new Oauth($this);
        $this->registrar = new Registrar($this);
        $this->services = new Services($this);
        $this->templates = new Templates($this);
        $this->tlds = new Tlds($this);
        $this->vanityNameServers = new VanityNameServers($this);
        $this->webhooks = new Webhooks($this);
        $this->zones = new Zones($this);
    }
}
