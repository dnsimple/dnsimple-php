<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Whoami;

final class IdentityServiceTest extends ServiceTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->service = new IdentityService($this->client);
    }

    public function testWhoami()
    {
        $this->mockResponseWith("whoami/success");

        $response = $this->service->whoami();
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        $this->assertInstanceOf(Whoami::class, $data);
        $this->assertObjectHasAttribute("user", $data);
        $this->assertObjectHasAttribute("account", $data);
    }

    public function testUser()
    {
        $this->mockResponseWith("whoami/success-user");
        $user = $this->service->whoami()->getData()->user;

        $this->assertEquals(1, $user->id);
        $this->assertEquals("example-user@example.com", $user->email);
        $this->assertEquals("2015-09-18T23:04:37Z", $user->created_at);
        $this->assertEquals("2016-06-09T20:03:39Z", $user->updated_at);
    }

    public function testAccount()
    {
        $this->mockResponseWith("whoami/success-account");
        $account = $this->service->whoami()->getData()->account;

        $this->assertEquals(1, $account->id);
        $this->assertEquals("example-account@example.com", $account->email);
        $this->assertEquals("dnsimple-professional", $account->plan_identifier);
        $this->assertEquals("2015-09-18T23:04:37Z", $account->created_at);
        $this->assertEquals("2016-06-09T20:03:39Z", $account->updated_at);
    }
}
