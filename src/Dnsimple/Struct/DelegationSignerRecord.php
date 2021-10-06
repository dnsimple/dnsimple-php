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
    public $id;
    /**
     * @var int The associated domain ID
     */
    public $domainId;
    /**
     * @var int The signing algorithm used
     */
    public $algorithm;
    /**
     * @var string The digest value
     */
    public $digest;
    /**
     * @var int The digest type used
     */
    public $digestType;
    /**
     * @var int The keytag for the associated DNSKEY
     */
    public $keytag;
    /**
     * @var string The public key that references the corresponding DNSKEY record
     */
    public $publicKey;
    /**
     * @var string When the delegation signing record was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the delegation signing record was last updated in DNSimple
     */
    public $updatedAt;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->domainId = $data->domain_id;
        $this->algorithm = $data->algorithm;
        $this->digest = $data->digest;
        $this->digestType = $data->digest_type;
        $this->keytag = $data->keytag;
        $this->publicKey = $data->public_key;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
    }

}
