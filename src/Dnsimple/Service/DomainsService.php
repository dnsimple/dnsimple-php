<?php

namespace Dnsimple\Service;

use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Collaborator;
use Dnsimple\Struct\DelegationSignerRecord;
use Dnsimple\Struct\Dnssec;
use Dnsimple\Struct\Domain;
use Dnsimple\Struct\DomainPush;
use Dnsimple\Struct\EmailForward;
use GuzzleHttp\RequestOptions;

/**
 * The Domains Service handles the domains endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/domains
 * @package Dnsimple
 */
class DomainsService extends ClientService
{
    /**
     * Lists the domains in the account.
     *
     * @param int $accountId The account ID
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible options:
     *  - filters:
     *      - name_like: Only include domains containing given string (i.e. ["name_like" => "example.com"] )
     *      - registrant_id: Only include domains containing given registrant ID (i.e. ["registrant_id" => 1010] )
     *  - sorting:
     *    Comma separated key-value pairs: the name of a field and the order criteria (asc for ascending and desc for
     *    descending).  ["sort" => "sort criteria here"]
     *    Sort criteria:
     *      - id: Sort domains by ID (i.e. "id:asc")
     *      - name: Sort domains by name (alphabetical order) (i.e. "name:desc")
     *      - expiration: Sort domains by expiration date (i.e. "expiration:asc")
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
     * @return  Response The list of domains
     * @example listDomains(1010, ["name_like" => "example.com", "sort" => "id:desc,expiration:asc"]
     */
    public function listDomains($accountId, $options = []): Response
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains"), $options);

        return new Response($response, Domain::class);
    }

    /**
     * Creates a domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/#create
     *
     * @param int $accountId The account ID
     * @param array $attributes The domain attributes (currently ["name" => "domain_name.com"])
     * @return  Response The newly created domain
     */
    public function createDomain($accountId, array $attributes): Response
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains"), [
            RequestOptions::JSON => $attributes,
        ]);

        return new Response($response, Domain::class);
    }

    /**
     * Retrieves the details of an existing domain.
     *
     * @see https://developer.dnsimple.com/v2/domains/#getDomain
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or ID
     * @return  Response The domain requested
     */
    public function getDomain($accountId, $domainIdentifier): Response
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        return new Response($response, Domain::class);
    }

    /**
     * Permanently deletes a domain from the account.
     *
     * For domains which are registered with DNSimple, this will not delete the domain from the registry,
     * nor perform a refund.
     *
     * @see https://developer.dnsimple.com/v2/domains/#deleteDomain
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or ID
     * @return  Response An empty response
     */
    public function deleteDomain($accountId, $domainIdentifier): Response
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}"));

        return new Response($response);
    }

    /**
     * List collaborators for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#listDomainCollaborators
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or ID
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
     * @return Response The list of collaborators
     */
    public function listCollaborators($accountId, $domainIdentifier, array $options = []): Response
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/collaborators"), $options);
        return new Response($response, Collaborator::class);
    }

    /**
     * Adds a collaborator for the domain in the account
     *
     * At the time of the add, a collaborator may or may not have a DNSimple account.
     *
     * In case the collaborator doesn"t have a DNSimple account, the system will invite her/him to register to
     * DNSimple first and then to accept the collaboration invitation.
     *
     * In the other case, she/he is automatically added to the domain as collaborator. She/he can decide to reject
     * the invitation later.
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#addDomainCollaborator
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or ID
     * @param array $attributes The collaborator attributes (i.e. ["email" => "user@example.com"])
     * @return Response The collaborator added to the domain in the account
     */
    public function addCollaborator($accountId, $domainIdentifier, array $attributes)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/collaborators"), $attributes);
        return new Response($response, Collaborator::class);
    }

    /**
     * Remove a collaborator from the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#removeDomainCollaborator
     *
     * @param int $accountId The account Id
     * @param string $domainIdentifier The domain name or id
     * @param int $collaboratorId The collaborator id
     * @return Response An empty response
     */
    public function removeCollaborator($accountId, $domainIdentifier, $collaboratorId)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/collaborators/{$collaboratorId}"));
        return new Response($response);
    }

    /**
     * Enable DNSSEC for the domain in the account. This will sign the zone. If the domain is registered it will also
     * add the DS record to the corresponding registry.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#enableDomainDnssec
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @return Response The DNSSEC status
     */
    public function enableDnssec($accountId, $domainIdentifier)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/dnssec"));
        return new Response($response, Dnssec::class);
    }

    /**
     * Disable DNSSEC for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#disableDomainDnssec
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @return Response An empty response
     */
    public function disableDnssec($accountId, $domainIdentifier)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/dnssec"));
        return new Response($response);
    }

    /**
     * Get the status of DNSSEC, indicating whether it is currently enabled or disabled.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#getDomainDnssec
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @return Response The DNSSEC status requested
     */
    public function getDnssec($accountId, $domainIdentifier)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/dnssec"));
        return new Response($response, Dnssec::class);
    }

    /**
     * List delegation signer records for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#listDomainDelegationSignerRecords
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible options:
     *  - sorting:
     *    Comma separated key-value pairs: the name of a field and the order criteria (asc for ascending and desc for
     *    descending).  ["sort" => "sort criteria here"]
     *    Sort criteria:
     *      - id: Sort delegation signer records by ID (i.e. "id:asc")
     *      - created_at: Sort delegation signer records by creation date (i.e. "created_at:desc")
     * @return Response A list of delegation signer records for the domain in the account
     */
    public function listDomainDelegationSignerRecords($accountId, $domainIdentifier, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/ds_records"), $options);
        return new Response($response, DelegationSignerRecord::class);
    }

    /**
     * Create a delegation signer record
     *
     * You only need to create a delegation signer record manually if your domain is registered with DNSimple but
     * hosted with another DNS provider that is signing your zone. To enable DNSSEC on a domain that is hosted with
     * DNSimple, use the DNSSEC enable endpoint.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#createDomainDelegationSignerRecord
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @param array $attributes The delegation signer record attributes to create the delegation signer record
     *  Required Fields
     *      - algorithm: DNSSEC algorithms defined in http://www.iana.org/assignments/dns-sec-alg-numbers/dns-sec-alg-numbers.xhtml - pass the Number value as a string (i.e. “8”).
     *      - digest: The hexidecimal representation of the digest of the corresponding DNSKEY record.
     *      - digest_type: DNSSEC digest types defined in http://www.iana.org/assignments/ds-rr-types/ds-rr-types.xhtml - pass the Number value as string (i.e. “2”).
     *      - keytag: A keytag that references the corresponding DNSKEY record.
     * @return Response The newly created domain delegation signer record
     */
    public function createDomainDelegationSignerRecord($accountId, $domainIdentifier, $attributes)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/ds_records"), $attributes);
        return new Response($response, DelegationSignerRecord::class);
    }

    /**
     * Get the delegation signer record under the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#getDomainDelegationSignerRecord
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or id
     * @param int $dsRecordId The delegation signer record id
     * @return Response The domain delegation signer record requested
     */
    public function getDomainDelegationSignerRecord($accountId, $domainIdentifier, $dsRecordId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/ds_records/{$dsRecordId}"));
        return new Response($response, DelegationSignerRecord::class);
    }

    /**
     * Delete the delegation signer record under the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#deleteDomainDelegationSignerRecord
     *
     * @param int $accountId The account ID
     * @param int|string $domainIdentifier The domain name or id
     * @param int $dsRecordId The delegation signer record id
     * @return Response An empty response
     */
    public function deleteDomainDelegationSignerRecord($accountId, $domainIdentifier, $dsRecordId)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/ds_records/{$dsRecordId}"));
        return new Response($response);
    }

    /**
     * List email forwards for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#listEmailForwards
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible options:
     *  - sorting:
     *    Comma separated key-value pairs: the name of a field and the order criteria (asc for ascending and desc for
     *    descending).  ["sort" => "sort criteria here"]
     *    Sort criteria:
     *      - id: Sort email forwards by ID (i.e. "id:asc")
     *      - from: Sort email forwards by sender (i.e. "from:desc")
     *      - to: Sort email forwards by recipient (i.e. "to:asc")
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
     * @return Response The list of email forwards for the domain in the account
     */
    public function listEmailForwards($accountId, $domainIdentifier, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/email_forwards"), $options);
        return new Response($response, EmailForward::class);
    }

    /**
     * Create an email forward under the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#createEmailForward
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @param array $attributes The email forwards attributes
     *  Required Fields
     *      - from: The email address the emails are sent to.
     *      - to: The email address the email address the emails are forwarded to.
     * @return Response The newly created email forward under the domain in the account
     */
    public function createEmailForward($accountId, $domainIdentifier, $attributes)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/email_forwards"), $attributes);
        return new Response($response, EmailForward::class);
    }

    /**
     * Get the email forward in the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#getEmailForward
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @param int $emailForward The email forward id
     * @return Response The email forward requested
     */
    public function getEmailForward($accountId, $domainIdentifier, $emailForward)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/email_forwards/{$emailForward}"));
        return new Response($response, EmailForward::class);
    }

    /**
     * Delete the email forward from the domain.
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#deleteEmailForward
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @param int $emailForward The email forward id
     * @return Response An empty response
     */
    public function deleteEmailForward($accountId, $domainIdentifier, $emailForward)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/email_forwards/{$emailForward}"));
        return new Response($response);
    }

    /**
     * Initiate a push for the domain.
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#initiate
     *
     * @param int $accountId The account id
     * @param int|string $domainIdentifier The domain name or id
     * @param array $attributes The data to send to initiate the push
     *  Required field:
     *      - new_account_email: The email address of the target DNSimple account.
     * @return Response The newly created domain push
     */
    public function initiatePush($accountId, $domainIdentifier, array $attributes)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domainIdentifier}/pushes"), $attributes);
        return new Response($response, DomainPush::class);
    }

    /**
     * List pending pushes for the target account.
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#listPushes
     *
     * @param int $accountId The account id
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible options:
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
     * @return Response The list of pushes for the domain
     */
    public function listPushes($accountId, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/pushes"), $options);
        return new Response($response, DomainPush::class);
    }

    /**
     * Accept a push for the target account
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#acceptPush
     *
     * @param int $accountId The account id
     * @param int $pushId The push id
     * @param array $attributes The data to send to accept the push
     *  Required field:
     *      - contact_id: A contact that belongs to the target DNSimple account. The contact will be used as new
     *                    registrant for the domain, if the domain is registered with DNSimple.
     * @return Response An empty response
     */
    public function acceptPush($accountId, $pushId, array $attributes)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/pushes/{$pushId}"), $attributes);
        return new Response($response);
    }

    /**
     * Reject a push for the target account
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#rejectPush
     *
     * @param int $accountId The account id
     * @param int $pushId The push id
     * @return Response An empty response
     */
    public function rejectPush($accountId, $pushId)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/pushes/{$pushId}"));
        return new Response($response);
    }
}
