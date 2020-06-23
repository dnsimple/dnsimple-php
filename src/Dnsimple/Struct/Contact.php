<?php


namespace Dnsimple\Struct;

/**
 * Represents a contact in DNSimple
 * @package Dnsimple\Struct
 */
class Contact
{
    /**
     * @var int The contact ID in DNSimple
     */
    public int $id;
    /**
     * @var int The associated account ID
     */
    public int $accountId;
    /**
     * @var string The label to represent the contact
     */
    public string $label;
    /**
     * @var string The contact first name
     */
    public string $firstName;
    /**
     * @var string The contact last name
     */
    public string $lastName;
    /**
     * @var string The contact's job title
     */
    public string $jobTitle;
    /**
     * @var string The name of the organization in which the contact works
     */
    public string $organizationName;
    /**
     * @var string The contact email address
     */
    public string $email;
    /**
     * @var string The contact phone number
     */
    public string $phone;
    /**
     * @var string The contact fax number (may be omitted)
     */
    public string $fax;
    /**
     * @var string The contact street address
     */
    public string $address1;
    /**
     * @var string Apartment or suite number
     */
    public string $address2;
    /**
     * @var string The city name
     */
    public string $city;
    /**
     * @var string The state or province name
     */
    public string $stateProvince;
    /**
     * @var string The contact postal code
     */
    public string $postalCode;
    /**
     * @var string The contact country (as a 2-character country code)
     */
    public string $country;
    /**
     * @var string When the contact was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the contact was last updated in DNSimple
     */
    public string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->accountId = $data->account_id;
        $this->label = $data->label;
        $this->firstName = $data->first_name;
        $this->lastName = $data->last_name;
        $this->jobTitle = $data->job_title;
        $this->organizationName = $data->organization_name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->fax = $data->fax;
        $this->address1 = $data->address1;
        $this->address2 = $data->address2;
        $this->city = $data->city;
        $this->stateProvince = $data->state_province;
        $this->postalCode = $data->postal_code;
        $this->country = $data->country;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }
}
