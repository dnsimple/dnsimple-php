<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;

class OauthTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Oauth($this->client);
    }

    public function testExchangeAuthorizationForToken()
    {
        $this->mockResponseWith("oauthAccessToken/success");

        $attributes = [
            "code" => "the_code",
            "client_id" => "my-super-service",
            "client_secret" => "shhhh",
            "state" => "some_state",
            "redirect_uri" => "the_uri"
        ];

        $oauthToken = $this->service->exchangeAuthorizationForToken($attributes)->getData();

        self::assertEquals("zKQ7OLqF5N1gylcJweA9WodA000BUNJD", $oauthToken->accessToken);
        self::assertEquals("Bearer", $oauthToken->tokenType);
        self::assertNull($oauthToken->scope);
        self::assertEquals(1, $oauthToken->accountId);
    }

    public function testExchangeAuthorizationForTokenInvalidRequest()
    {
        $this->mockResponseWith("oauthAccessToken/error-invalid-request");

        $this->expectException(DnsimpleException::class);

        $attributes = [ "code" => "the_code", "client_id" => "my-super-service", "client_secret" => "shhhh",
            "state" => "some_state", "redirect_uri" => "the_uri" ];
        $this->service->exchangeAuthorizationForToken($attributes);
    }

    public function testAuthorizeUrl()
    {
        $url = $this->service->authorizeUrl("great-app");

        self::assertEquals("https://api.dnsimple.com/oauth/authorize?client_id=great-app&response_type=code", $url);
    }

    public function testAuthorizeUrlWithAttributes()
    {
        $attributes = [
            "redirect_url" => "http://example.com",
            "state" => "secret",
            "scope" => "micro"
        ];

        $url = $this->service->authorizeUrl("great-app", $attributes);

        self::assertEquals("https://api.dnsimple.com/oauth/authorize?client_id=great-app&response_type=code&redirect_url=http%3A%2F%2Fexample.com&state=secret&scope=micro", $url);
    }
}
