<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Exceptions\BadRequestException;
use Dnsimple\Response;
use Dnsimple\Struct\Contact;

class ContactsTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Contacts($this->client);
    }

    public function testListContacts()
    {
        $this->mockResponseWith("listContacts/success");

        $response = $this->service->listContacts(1010);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(2, $data);

        $contact = $data[0];
        self::assertInstanceOf(Contact::class, $contact);
    }

    public function testListContactsSupportsSorting()
    {
        $this->mockResponseWith("listContacts/success");

        $this->service->listContacts(1010, ["sort" => "id:asc,label:desc,email:asc"]);

        self::assertEquals("sort=id%3Aasc%2Clabel%3Adesc%2Cemail%3Aasc", $this->queryContent());
    }

    public function testListContactsHasPaginationObject()
    {
        $this->mockResponseWith("listContacts/success");

        $response = $this->service->listContacts(1010);
        $pagination = $response->getPagination();

        self::assertEquals(1, $pagination->currentPage);
        self::assertEquals(30, $pagination->perPage);
        self::assertEquals(2, $pagination->totalEntries);
        self::assertEquals(1, $pagination->totalPages);
    }

    public function testListContactsSupportsPagination()
    {
        $this->mockResponseWith("listContacts/success");

        $this->service->listContacts(1010, ["page" => 1, "per_page" => 2]);

        self::assertEquals("page=1&per_page=2", $this->queryContent());
    }

    public function testCreateContact()
    {
        $this->mockResponseWith("createContact/created");

        $attributes = [
            "first_name" => "First",
            "last_name" => "User",
            "address1" => "Italian Street, 10",
            "city" => "Roma",
            "state_province" => "RM",
            "postal_code" => "00100",
            "country" => "IT",
            "email" => "first@example.com",
            "phone" => "+18001234567"
        ];
        $contact = $this->service->createContact(1010, $attributes)->getData();

        self::assertInstanceOf(Contact::class, $contact);
    }

    public function testGetContact()
    {
        $this->mockResponseWith("getContact/success");

        $contact = $this->service->getContact(1010, 1)->getData();

        self::assertEquals(1, $contact->id);
        self::assertEquals(1010, $contact->accountId);
        self::assertEquals("Default", $contact->label);
        self::assertEquals("First", $contact->firstName);
        self::assertEquals("User", $contact->lastName);
        self::assertEquals("CEO", $contact->jobTitle);
        self::assertEquals("Awesome Company", $contact->organizationName);
        self::assertEquals("first@example.com", $contact->email);
        self::assertEquals("+18001234567", $contact->phone);
        self::assertEquals("+18011234567", $contact->fax);
        self::assertEquals("Italian Street, 10", $contact->address1);
        self::assertEmpty($contact->address2);
        self::assertEquals("Roma", $contact->city);
        self::assertEquals("RM", $contact->stateProvince);
        self::assertEquals("IT", $contact->country);
        self::assertEquals("00100", $contact->postalCode);
        self::assertEquals("2016-01-19T20:50:26Z", $contact->createdAt);
        self::assertEquals("2016-01-19T20:50:26Z", $contact->updatedAt);
    }

    public function testUpdateContact()
    {
        $this->mockResponseWith("updateContact/success");

        $attributes = [
            "first_name" => "First"
        ];
        $response = $this->service->updateContact(1010, 1, $attributes);
        $contact = $response->getData();

        self::assertEquals(200, $response->getStatusCode());
        self::assertInstanceOf(Contact::class, $contact);
    }

    public function testDeleteContact()
    {
        $this->mockResponseWith("deleteContact/success");
        $response = $this->service->deleteContact(1010, 1);

        self::assertEquals(204, $response->getStatusCode());
    }

    public function testDeleteContactInUse()
    {
        $this->mockResponseWith("deleteContact/error-contact-in-use");
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("The contact cannot be deleted because it's currently in use");

        $this->service->deleteContact(1010, 1);
    }
}
