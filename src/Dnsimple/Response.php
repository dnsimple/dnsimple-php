<?php

namespace Dnsimple;

use Dnsimple\Struct\Pagination;
use Psr\Http\Message\ResponseInterface;

/**
 * Wrapper holding the whole http response as well as the data returned by an call to an endpoint of the DNSimple API.
 *
 * @package Dnsimple
 */
class Response
{
    /**
     * @var ResponseInterface $_httpResponse The raw http response
     */
    private ResponseInterface $_httpResponse;

    /**
     * @var mixed The structure that will be created with the data in the request body
     */
    private $_data_class;

    /**
     * Response constructor.
     *
     * @param ResponseInterface $response
     * @param $data_class
     */
    public function __construct($response, $data_class = null)
    {
        $this->_httpResponse = $response;
        $this->_data_class = $data_class;
    }

    public function getStatusCode(): int
    {
        return $this->_httpResponse->getStatusCode();
    }

    /**
     * Returns the data found in the request body wrapped inside a structure.
     *
     * @return array|mixed Either an object or array of objects
     */
    public function getData()
    {
        $json = json_decode($this->_httpResponse->getBody())->data;
        if (is_array($json))
        {
            if ($this->_data_class != null)
                return array_map(function($args) { return new $this->_data_class($args); }, $json);
            else
                return array_map(function($arg) { return $arg;}, $json);
        } else {
            return new $this->_data_class($json);
        }
    }

    /**
     * Returns the pagination object.
     *
     * @return Pagination The pagination object.
     */
    public function getPagination() {
        return new Pagination(json_decode($this->_httpResponse->getBody())->pagination);
    }

    /**
     * The maximum number of requests you can perform per hour.
     *
     * @return int The rate limit
     */
    public function getRateLimit(): int
    {
        return $this->_httpResponse->getHeaderLine("X-RateLimit-Limit");
    }

    /**
     * The number of requests remaining in the current rate limit window.
     *
     * @return int The remaining requests
     */
    public function getRateLimitRemaining(): int
    {
        return $this->_httpResponse->getHeaderLine("X-RateLimit-Remaining");
    }

    /**
     * The time at which the current rate limit window in Unix time format.
     *
     * @return int When the rate limits will reset again.
     */
    public function getRateLimitReset(): int
    {
        return $this->_httpResponse->getHeaderLine("X-RateLimit-Reset");
    }
}
