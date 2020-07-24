<?php


namespace Dnsimple\Struct;

/**
 * Represents a collaborator for a domain in the account
 *
 * @see https://developer.dnsimple.com/v2/domains/collaborators/
 * @package Dnsimple\Struct
 */
class Collaborator
{
    /**
     * @var int The collaborator ID in DNSimple
     */
    public $id;
    /**
     * @var int The associated domain ID
     */
    public $domainId;
    /**
     * @var string The associated domain name
     */
    public $domainName;
    /**
     * @var int|null The user ID (if the collaborator accepted the invitation).
     */
    public $userId;
    /**
     * @var string The user email
     */
    public $userEmail;
    /**
     * @var bool Invitation
     */
    public $invitation;
    /**
     * @var string When the collaborator was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the collaborator was last updated in DNSimple
     */
    public $updatedAt;
    /**
     * @var string|null When the collaborator accepted the invitation
     */
    public $acceptedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->domainName = $data->domain_name;
        $this->userId = $data->user_id;
        $this->userEmail = $data->user_email;
        $this->invitation = $data->invitation;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
        $this->acceptedAt = $data->accepted_at;
    }
}
