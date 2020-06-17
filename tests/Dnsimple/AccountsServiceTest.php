<?php

namespace Dnsimple;


class AccountsServiceTest extends ServiceTestCase
{
    function setUp(): void
    {
        parent::setUp();
        $this->service = new AccountsService($this->client);
    }

    function testListAccountsAccount()
    {
        $this->mockResponseWith("listAccounts/success-account");
        $accounts = $this->service->listAccounts()->getData();

        $this->assertCount(1, $accounts);
        $this->assertEquals("john@example.com", $accounts[0]->email);
    }

    function testListAccountsUser()
    {
        $this->mockResponseWith("listAccounts/success-user");
        $accounts = $this->service->listAccounts()->getData();

        $this->assertCount(2, $accounts);
        $this->assertEquals("ops@company.com", $accounts[1]->email);
    }
}
