<?php

namespace Dnsimple;


use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * @var ResponseInterface $_httpResponse
     */
    private ResponseInterface $_httpResponse;


    /**
     * Response constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct($response)
    {
        $this->_httpResponse = $response;
    }

    /**
     * @return  ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->_httpResponse;
    }

    public function getStatusCode(): int
    {
        return $this->_httpResponse->getStatusCode();
    }

    public function getData()
    {
        return json_decode($this->_httpResponse->getBody())->data;
    }

    public function getRateLimit(): int
    {
        return $this->_httpResponse->getHeaderLine("X-RateLimit-Limit");
    }

    public function getRateLimitRemaining(): int
    {
        return $this->_httpResponse->getHeaderLine("X-RateLimit-Remaining");
    }

    public function getRateLimitReset(): int
    {
        return $this->_httpResponse->getHeaderLine("X-RateLimit-Reset");
    }
}
