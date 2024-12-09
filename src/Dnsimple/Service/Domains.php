<?php

namespace Dnsimple\Service;

use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\Collaborator;
use Dnsimple\Struct\DelegationSignerRecord;
use Dnsimple\Struct\Dnssec;
use Dnsimple\Struct\Domain;
use Dnsimple\Struct\DomainPush;
use Dnsimple\Struct\EmailForward;

/**
 * The Domains Service handles the domains endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/domains
 * @package Dnsimple
 */
class Domains extends ClientService
{
    /**
     * Lists the domains in the account.
     *
     * @param int $account The account ID
     * @param array $options key/value options to sort and filter the results
     * @return  Response The list of domains
     * @example listDomains(1010, ["name_like" => "example.com", "sort" => "id:desc,expiration:asc"]
     * @throws DnsimpleException When something goes wrong
     */
    public function listDomains($account, $options = []): Response
    {
        $response = $this->get("/{$account}/domains", $options);

        return new Response($response, Domain::class);
    }

    /**
     * Creates a domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/#create
     *
     * @param int $account The account ID
     * @param array $attributes The domain attributes. Refer to the documentation for the list of available fields.
     * @return  Response The newly created domain
     * @throws DnsimpleException When something goes wrong
     */
    public function createDomain($account, array $attributes): Response
    {
        $response = $this->post("/{$account}/domains", $attributes);

        return new Response($response, Domain::class);
    }

    /**
     * Retrieves the details of an existing domain.
     *
     * @see https://developer.dnsimple.com/v2/domains/#getDomain
     *
     * @param int $account The account ID
     * @param int|string $domain The domain name or ID
     * @return  Response The domain requested
     * @throws DnsimpleException When something goes wrong
     */
    public function getDomain($account, $domain): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}");

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
     * @param int $account The account ID
     * @param int|string $domain The domain name or ID
     * @return  Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function deleteDomain($account, $domain): Response
    {
        $response = $this->delete("/{$account}/domains/{$domain}");

        return new Response($response);
    }

    /**
     * List collaborators for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#listDomainCollaborators
     *
     * @param int $account The account ID
     * @param int|string $domain The domain name or ID
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of collaborators
     * @throws DnsimpleException When something goes wrong
     * @deprecated `DomainCollaborators` have been deprecated and will be removed in the next major version. Please use our Domain Access Control feature.
     */
    public function listCollaborators($account, $domain, array $options = []): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}/collaborators", $options);
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
     * @param int $account The account ID
     * @param int|string $domain The domain name or ID
     * @param array $attributes The collaborator attributes. Refer to the documentation for the list of available fields.
     * @return Response The collaborator added to the domain in the account
     * @throws DnsimpleException When something goes wrong
     * @deprecated `DomainCollaborators` have been deprecated and will be removed in the next major version. Please use our Domain Access Control feature.
     */
    public function addCollaborator($account, $domain, array $attributes): Response
    {
        $response = $this->post("/{$account}/domains/{$domain}/collaborators", $attributes);
        return new Response($response, Collaborator::class);
    }

    /**
     * Remove a collaborator from the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/collaborators/#removeDomainCollaborator
     *
     * @param int $account The account Id
     * @param string $domain The domain name or id
     * @param int $collaborator The collaborator id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     * @deprecated `DomainCollaborators` have been deprecated and will be removed in the next major version. Please use our Domain Access Control feature.
     */
    public function removeCollaborator($account, $domain, $collaborator): Response
    {
        $response = $this->delete("/{$account}/domains/{$domain}/collaborators/{$collaborator}");
        return new Response($response);
    }

    /**
     * Enable DNSSEC for the domain in the account. This will sign the zone. If the domain is registered it will also
     * add the DS record to the corresponding registry.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#enableDomainDnssec
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response The DNSSEC status
     * @throws DnsimpleException When something goes wrong
     */
    public function enableDnssec($account, $domain): Response
    {
        $response = $this->post("/{$account}/domains/{$domain}/dnssec");
        return new Response($response, Dnssec::class);
    }

    /**
     * Disable DNSSEC for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#disableDomainDnssec
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function disableDnssec($account, $domain): Response
    {
        $response = $this->delete("/{$account}/domains/{$domain}/dnssec");
        return new Response($response);
    }

    /**
     * Get the status of DNSSEC, indicating whether it is currently enabled or disabled.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#getDomainDnssec
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response The DNSSEC status requested
     * @throws DnsimpleException When something goes wrong
     */
    public function getDnssec($account, $domain): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}/dnssec");
        return new Response($response, Dnssec::class);
    }

    /**
     * List delegation signer records for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#listDomainDelegationSignerRecords
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $options key/value options to sort and filter the results
     * @return Response A list of delegation signer records for the domain in the account
     * @throws DnsimpleException When something goes wrong
     */
    public function listDomainDelegationSignerRecords($account, $domain, array $options = []): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}/ds_records", $options);
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
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $attributes The delegation signer record attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created domain delegation signer record
     * @throws DnsimpleException When something goes wrong
     */
    public function createDomainDelegationSignerRecord($account, $domain, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/domains/{$domain}/ds_records", $attributes);
        return new Response($response, DelegationSignerRecord::class);
    }

    /**
     * Get the delegation signer record under the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#getDomainDelegationSignerRecord
     *
     * @param int $account The account ID
     * @param int|string $domain The domain name or id
     * @param int $dsRecordId The delegation signer record id
     * @return Response The domain delegation signer record requested
     * @throws DnsimpleException When something goes wrong
     */
    public function getDomainDelegationSignerRecord($account, $domain, $dsRecordId): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}/ds_records/{$dsRecordId}");
        return new Response($response, DelegationSignerRecord::class);
    }

    /**
     * Delete the delegation signer record under the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/dnssec/#deleteDomainDelegationSignerRecord
     *
     * @param int $account The account ID
     * @param int|string $domain The domain name or id
     * @param int $dsRecordId The delegation signer record id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function deleteDomainDelegationSignerRecord($account, $domain, $dsRecordId): Response
    {
        $response = $this->delete("/{$account}/domains/{$domain}/ds_records/{$dsRecordId}");
        return new Response($response);
    }

    /**
     * List email forwards for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#listEmailForwards
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of email forwards for the domain in the account
     * @throws DnsimpleException When something goes wrong
     */
    public function listEmailForwards($account, $domain, array $options = []): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}/email_forwards", $options);
        return new Response($response, EmailForward::class);
    }

    /**
     * Create an email forward under the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#createEmailForward
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $attributes The email forwards attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created email forward under the domain in the account
     * @throws DnsimpleException When something goes wrong
     */
    public function createEmailForward($account, $domain, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/domains/{$domain}/email_forwards", $attributes);
        return new Response($response, EmailForward::class);
    }

    /**
     * Get the email forward in the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#getEmailForward
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $emailForward The email forward id
     * @return Response The email forward requested
     * @throws DnsimpleException When something goes wrong
     */
    public function getEmailForward($account, $domain, $emailForward): Response
    {
        $response = $this->get("/{$account}/domains/{$domain}/email_forwards/{$emailForward}");
        return new Response($response, EmailForward::class);
    }

    /**
     * Delete the email forward from the domain.
     *
     * @see https://developer.dnsimple.com/v2/domains/email-forwards/#deleteEmailForward
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $emailForward The email forward id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function deleteEmailForward($account, $domain, $emailForward): Response
    {
        $response = $this->delete("/{$account}/domains/{$domain}/email_forwards/{$emailForward}");
        return new Response($response);
    }

    /**
     * Initiate a push for the domain.
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#initiate
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $attributes The initiate push attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created domain push
     * @throws DnsimpleException When something goes wrong
     */
    public function initiatePush($account, $domain, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/domains/{$domain}/pushes", $attributes);
        return new Response($response, DomainPush::class);
    }

    /**
     * List pending pushes for the target account.
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#listPushes
     *
     * @param int $account The account id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of pushes for the domain
     * @throws DnsimpleException When something goes wrong
     */
    public function listPushes($account, array $options = []): Response
    {
        $response = $this->get("/{$account}/pushes", $options);
        return new Response($response, DomainPush::class);
    }

    /**
     * Accept a push for the target account
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#acceptPush
     *
     * @param int $account The account id
     * @param int $push The push id
     * @param array $attributes The accept push attributes. Refer to the documentation for the list of available fields.
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function acceptPush($account, $push, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/pushes/{$push}", $attributes);
        return new Response($response);
    }

    /**
     * Reject a push for the target account
     *
     * @see https://developer.dnsimple.com/v2/domains/pushes/#rejectPush
     *
     * @param int $account The account id
     * @param int $push The push id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function rejectPush($account, $push): Response
    {
        $response = $this->delete("/{$account}/pushes/{$push}");
        return new Response($response);
    }
}
