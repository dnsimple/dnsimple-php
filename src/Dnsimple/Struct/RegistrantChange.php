<?php

namespace Dnsimple\Struct;

class RegistrantChange
{
    /**
     * @var int The registrant ID in DNSimple
     */
    public $id;
    /**
     * @var int The account ID in DNSimple
     */
    public $accountId;
    /**
     * @var int The contact ID in DNSimple
     */
    public $contactId;
    /**
     * @var int The domain ID in DNSimple
     */
    public $domainId;
    /**
     * @var string The registrant change state
     * This can be one of: new, pending, cancelling, cancelled, completed
     */
    public $state;
    /**
     * @var array The extended attributes
     */
    public $extendedAttributes; // Assuming TradeExtendedAttributes is an associative array
    /**
     * @var bool Whether the registrant change is a registry owner change
     */
    public $registryOwnerChange;
    /**
     * @var string|null The contact ID of the IRT contact that lifted the lock
     */
    public $irtLockLiftedBy;
    /**
     * @var string When the registrant change was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the registrant change was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data["id"];
        $this->accountId = $data["account_id"];
        $this->contactId = $data["contact_id"];
        $this->domainId = $data["domain_id"];
        $this->state = $data["state"];
        $this->extendedAttributes = $data["extended_attributes"];
        $this->registryOwnerChange = $data["registry_owner_change"];
        $this->irtLockLiftedBy = $data["irt_lock_lifted_by"];
        $this->createdAt = $data["created_at"];
        $this->updatedAt = $data["updated_at"];
    }
}
