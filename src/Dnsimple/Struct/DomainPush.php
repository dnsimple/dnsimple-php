<?php


namespace Dnsimple\Struct;

/**
 * Represents a domain push
 * @package Dnsimple\Struct
 */
class DomainPush
{
    /**
     * @var int The domain push ID in DNSimple
     */
    public int $id;
    /**
     * @var int The associated domain ID
     */
    public int $domainId;
    /**
     * @var int|null The associated contact ID
     */
    public ?int $contactId;
    /**
     * @var int The associated account ID
     */
    public int $accountId;
    /**
     * @var string When the domain push was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the domain push was last updated in DNSimple
     */
    public string $updatedAt;
    /**
     * @var string|null When the domain push was accepted in DNSimple
     */
    public ?string $acceptedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->contactId = $data->contact_id;
        $this->accountId = $data->account_id;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
        $this->acceptedAt = $data->accepted_at;
    }
}
