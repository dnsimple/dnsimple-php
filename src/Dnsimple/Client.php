<?php

namespace Dnsimple;


/**
 * The version of this Dnsimple client library.
 *
 * @see http://semver.org/ This project uses Semantic Versioning 2.0.0
 */
const VERSION = "0.0.0-dev";


/**
 * A PHP client for the DNSimple API v2.
 */
class Client
{
    /**
     * The current API version.
     */
    const API_VERSION = "v2";

    /**
     * The default base URL for API requests.
     */
    const BASE_URL = "https://api.sandbox.dnsimple.com";


    /**
     * @var string $accessToken the bearer authentication token
     */
    private $accessToken;

    /**
     * @var \GuzzleHttp\Client $httpClient the HTTP client
     */
    private $httpClient;


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


    public function __construct($accessToken, array $config = array())
    {
        $this->accessToken = $accessToken;
        $this->httpClient = new \GuzzleHttp\Client(
            array_merge(["base_uri" => self::BASE_URL], $config)
        );
    }

    public function get($path, array $options = [])
    {
        return $this->request("GET", $path, $options);
    }

    public function post($path, array $options = [])
    {
        return $this->request("POST", $path, $options);
    }

    public function delete($path, array $options = [])
    {
        return $this->request("DELETE", $path, $options);
    }

    public function request($method, $path, array $options = [])
    {
        $requestOptions = array_merge_recursive($options, [
            "headers" => [
                "Authorization" => "Bearer $this->accessToken",
                "Accept" => "application/json",
                "User-Agent" => "dnsimple-php/".VERSION,
            ]
        ]);

        return $this->httpClient->request($method, $path, $requestOptions);
    }
}
