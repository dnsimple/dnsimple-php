<?php

namespace Dnsimple\Struct;

class RegistrantChangeCheck
{
    /**
     * @var int The contact ID in DNSimple
     */
    public $contactId;
    /**
     * @var int The domain ID in DNSimple
     */
    public $domainId;
    /**
     * @var array The extended attributes
     */
    public $extendedAttributes; // This will be an array of ExtendedAttribute objects
    /**
     * @var bool Whether the registrant change is a registry owner change
     */
    public $registryOwnerChange;

    public function __construct($data)
    {
        $this->contactId = $data["contact_id"];
        $this->domainId = $data["domain_id"];
        $this->extendedAttributes = array_map(function ($item) {
            return new ExtendedAttribute($item);
        }, $data["extended_attributes"]);
        $this->registryOwnerChange = $data["registry_owner_change"];
    }
}
