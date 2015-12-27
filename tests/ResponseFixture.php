<?php

class ResponseFixture
{
    public static function newFromText($text)
    {
        $headers = [];
        $body    = null;

        $lines = explode("\r\n", $text);

        // extract the code
        preg_match('/\AHTTP(?:\/(\d+\.\d+))?\s+(\d\d\d)\s*(.*)\z/i', $lines[0], $matches);
        $status = $matches[2];

        // extract the headers
        $index = 1;
        while (($line = $lines[$index]) && ($line != "")) {
            list($key, $value) = explode(":", $line);
            $headers[$key] = $value;
            $index += 1;
        }

        // extract the body
        $index += 1;
        if (isset($lines[$index])) {
            $body = $lines[$index];
        }

        return new GuzzleHttp\Psr7\Response($status, $headers, $body);
    }

    public static function newFromFile($file) {
        return self::newFromText(file_get_contents($file));
    }
}