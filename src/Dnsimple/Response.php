<?php

namespace Dnsimple;


class Response
{
    /**
     * @var \GuzzleHttp\Psr7\Response $_httpResponse
     */
    private $_httpResponse;


    /**
     * Response constructor.
     *
     * @param \GuzzleHttp\Psr7\Response $response
     */
    public function __construct($response)
    {
        $this->_httpResponse = $response;
    }

    public function getData()
    {
        return json_decode($this->_httpResponse->getBody())->data;
    }
}
