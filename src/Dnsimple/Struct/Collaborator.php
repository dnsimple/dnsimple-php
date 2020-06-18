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
    public int $id;
    /**
     * @var int The associated domain ID
     */
    public int $domain_id;
    /**
     * @var string The associated domain name
     */
    public string $domain_name;
    /**
     * @var int|null The user ID (if the collaborator accepted the invitation).
     */
    public ?int $user_id;
    /**
     * @var string The user email
     */
    public string $user_email;
    /**
     * @var bool Invitation
     */
    public bool $invitation;
    /**
     * @var string When the collaborator was created in DNSimple
     */
    public string $created_at;
    /**
     * @var string When the collaborator was last updated in DNSimple
     */
    public string $updated_at;
    /**
     * @var string|null When the collaborator accepted the invitation
     */
    public ?string $accepted_at;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domain_id = $data->domain_id;
        $this->domain_name = $data->domain_name;
        $this->user_id = $data->user_id;
        $this->user_email = $data->user_email;
        $this->invitation = $data->invitation;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->accepted_at = $data->accepted_at;
    }
}
