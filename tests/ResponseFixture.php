<?php

class ResponseFixture
{
    private $status  = 200;
    private $headers = [];
    private $body;


    public function __construct($text)
    {
        $lines = explode("\r\n", $text);

        // extract the code
        preg_match('/\AHTTP(?:\/(\d+\.\d+))?\s+(\d\d\d)\s*(.*)\z/i', $lines[0], $matches);
        $this->status = $matches[2];

        // extract the headers
        $index = 1;
        while (($line = $lines[$index]) && ($line != "")) {
            list($key, $value) = explode(":", $line);
            $this->headers[$key] = $value;
            $index += 1;
        }

        // extract the body
        $index += 1;
        if (isset($lines[$index])) {
            $this->body = $lines[$index];
        }
    }

    public function getResponse() {
        return new GuzzleHttp\Psr7\Response($this->status, $this->headers, $this->body);
    }
}