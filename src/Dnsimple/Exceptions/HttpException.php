<?php

namespace Dnsimple\Exceptions;

use Dnsimple\DnsimpleException;

use Psr\Http\Message\ResponseInterface;

/**
 * @package Dnsimple\Exceptions
 */
class HttpException extends DnsimpleException
{
    /**
     * Construct exception from response object.
     * @param ResponseInterface $response
     * @param Exception $previous
     * @return HttpException
     */
    public static function fromResponse(ResponseInterface $response, \Exception $previous = null)
    {
        $message = $response->getReasonPhrase();
        $code = $response->getStatusCode();
        $json = json_decode($response->getBody());
        if (property_exists($json, "message")) {
            $message = $json->message;
        }
        $exception = new static($message, $code, $previous);
        $exception->setResponse($response);
        return $exception;
    }

    /**
     * The response to the request.
     * @var ResponseInterface|null
     */
    protected $response = null;

    /**
     * @var array Errors loaded from the response
     */
    private $errors;

    /**
     * Set the response that caused the exception.
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get the response that caused the exception.
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * Get the HTTP status code.
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * Returns the errors found in the response.
     *
     * @return array The errors
     */
    public function getErrors(): array
    {
      if (empty($this->errors)) {
          $json = json_decode($this->response->getBody());
          if (property_exists($json, "errors")) {
              $this->errors = (array) $json->errors;
          }
      }
      return $this->errors;
    }
}
