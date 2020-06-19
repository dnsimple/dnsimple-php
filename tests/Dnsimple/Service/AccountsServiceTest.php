<?php

namespace Dnsimple\Service;


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

        self::assertCount(1, $accounts);
        self::assertEquals("john@example.com", $accounts[0]->email);
    }

    function testListAccountsUser()
    {
        $this->mockResponseWith("listAccounts/success-user");
        $accounts = $this->service->listAccounts()->getData();

        self::assertCount(2, $accounts);
        self::assertEquals("ops@company.com", $accounts[1]->email);
    }
}
