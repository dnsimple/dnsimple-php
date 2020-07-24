<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Whoami;

final class IdentityTest extends ServiceTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->service = new Identity($this->client);
    }

    public function testWhoami()
    {
        $this->mockResponseWith("whoami/success");

        $response = $this->service->whoami();
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertInstanceOf(Whoami::class, $data);
        self::assertObjectHasAttribute("user", $data);
        self::assertObjectHasAttribute("account", $data);
    }

    public function testUser()
    {
        $this->mockResponseWith("whoami/success-user");
        $user = $this->service->whoami()->getData()->user;

        self::assertEquals(1, $user->id);
        self::assertEquals("example-user@example.com", $user->email);
        self::assertEquals("2015-09-18T23:04:37Z", $user->createdAt);
        self::assertEquals("2016-06-09T20:03:39Z", $user->updatedAt);
    }

    public function testAccount()
    {
        $this->mockResponseWith("whoami/success-account");
        $account = $this->service->whoami()->getData()->account;

        self::assertEquals(1, $account->id);
        self::assertEquals("example-account@example.com", $account->email);
        self::assertEquals("dnsimple-professional", $account->planIdentifier);
        self::assertEquals("2015-09-18T23:04:37Z", $account->createdAt);
        self::assertEquals("2016-06-09T20:03:39Z", $account->updatedAt);
    }
}
