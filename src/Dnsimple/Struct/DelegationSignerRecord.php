<?php


namespace Dnsimple\Struct;

/**
 * Represents a delegation signer record
 *
 * @package Dnsimple\Struct
 */
class DelegationSignerRecord
{
    /**
     * @var int The ID of the delegation signer record in DNSimple
     */
    public int $id;
    /**
     * @var int The associated domain ID
     */
    public int $domainId;
    /**
     * @var int The signing algorithm used
     */
    public int $algorithm;
    /**
     * @var string The digest value
     */
    public string $digest;
    /**
     * @var int The digest type used
     */
    public int $digestType;
    /**
     * @var int The keytag for the associated DNSKEY
     */
    public int $keytag;
    /**
     * @var string When the delegation signing record was created in DNSimple
     */
    public string $createdAt;
    /**
     * @var string When the delegation signing record was last updated in DNSimple
     */
    public string $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->algorithm = $data->algorithm;
        $this->digest = $data->digest;
        $this->digestType = $data->digest_type;
        $this->keytag = $data->keytag;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }

}
