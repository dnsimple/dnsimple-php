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
    public $id;
    /**
     * @var int The associated account ID
     */
    public $accountId;
    /**
     * @var string The label to represent the contact
     */
    public $label;
    /**
     * @var string The contact first name
     */
    public $firstName;
    /**
     * @var string The contact last name
     */
    public $lastName;
    /**
     * @var string The contact's job title
     */
    public $jobTitle;
    /**
     * @var string The name of the organization in which the contact works
     */
    public $organizationName;
    /**
     * @var string The contact email address
     */
    public $email;
    /**
     * @var string The contact phone number
     */
    public $phone;
    /**
     * @var string The contact fax number (may be omitted)
     */
    public $fax;
    /**
     * @var string The contact street address
     */
    public $address1;
    /**
     * @var string Apartment or suite number
     */
    public $address2;
    /**
     * @var string The city name
     */
    public $city;
    /**
     * @var string The state or province name
     */
    public $stateProvince;
    /**
     * @var string The contact postal code
     */
    public $postalCode;
    /**
     * @var string The contact country (as a 2-character country code)
     */
    public $country;
    /**
     * @var string When the contact was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the contact was last updated in DNSimple
     */
    public $updatedAt;

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
