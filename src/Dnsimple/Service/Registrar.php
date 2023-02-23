<?php

namespace Dnsimple\Service;


use Dnsimple\DnsimpleException;
use Dnsimple\Response;
use Dnsimple\Struct\DomainCheck;
use Dnsimple\Struct\DomainPremiumPrice;
use Dnsimple\Struct\DomainRegistration;
use Dnsimple\Struct\DomainRenewal;
use Dnsimple\Struct\DomainPrice;
use Dnsimple\Struct\DomainTransfer;
use Dnsimple\Struct\VanityNameServer;
use Dnsimple\Struct\WhoisPrivacy;

/**
 * The Registrar Service handles the registrar endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/registrar
 * @package Dnsimple
 */
class Registrar extends ClientService
{
    /**
     * Checks whether a domain is available to be registered.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#checkDomain
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @return Response The domain check result
     * @throws DnsimpleException When something goes wrong
     */
    public function checkDomain($account, $domain): Response
    {
        $response = $this->get("/{$account}/registrar/domains/{$domain}/check");
        return new Response($response, DomainCheck::class);
    }

    /**
     * Get the premium price for a domain.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#getDomainPremiumPrice
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param string $action Optional action between "registration", "renewal", and "transfer". If omitted, it defaults to "registration".
     * @return Response The domain premium price
     * @throws DnsimpleException When something goes wrong
     * @deprecated getDomainPremiumPrice has been deprecated, use getDomainPrices instead
     */
    public function getDomainPremiumPrice($account, $domain, $action = "registration"): Response
    {
        $options = ["action" => $action];
        $response = $this->get("/{$account}/registrar/domains/{$domain}/premium_price", $options);
        return new Response($response, DomainPremiumPrice::class);
    }

    /**
     * Get prices for a domain.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#getDomainPrices
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @return Response The domain price response
     * @throws DnsimpleException When something goes wrong
     */
    public function getDomainPrices($account, $domain): Response
    {
        $response = $this->get("/{$account}/registrar/domains/{$domain}/prices");
        return new Response($response, DomainPrice::class);
    }

    /**
     * Registers a domain
     *
     * @see https://developer.dnsimple.com/v2/registrar/#registerDomain
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param array $attributes The domain registration attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly registered domain
     * @throws DnsimpleException When something goes wrong
     */
    public function registerDomain($account, $domain, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/registrar/domains/{$domain}/registrations", $attributes);
        return new Response($response, DomainRegistration::class);
    }

    /**
     * Retrieves the details of an existing domain registration.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#getDomainRegistration
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param int $domainRegistration The domain registration id
     * @return Response The details of an existing domain registration
     * @throws DnsimpleException When something goes wrong
     */
    public function getDomainRegistration($account, $domain, $domainRegistration): Response
    {
        $response = $this->get("/{$account}/registrar/domains/{$domain}/registrations/{$domainRegistration}");
        return new Response($response, DomainRegistration::class);
    }

    /**
     * Starts the transfer of a domain to DNSimple
     *
     * @see https://developer.dnsimple.com/v2/registrar/#transferDomain
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param array $attributes The domain transfer attributes. Refer to the documentation for the list of available fields.
     * @return Response The domain transfer
     * @throws DnsimpleException When something goes wrong
     */
    public function transferDomain($account, $domain, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/registrar/domains/{$domain}/transfers", $attributes);
        return new Response($response, DomainTransfer::class);
    }

    /**
     * Retrieves the details of an existing domain transfer.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#getDomainTransfer
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param int $domainTransfer The domain transfer id
     * @return Response The details of an existing domain transfer
     * @throws DnsimpleException When something goes wrong
     */
    public function getDomainTransfer($account, $domain, $domainTransfer): Response
    {
        $response = $this->get("/{$account}/registrar/domains/{$domain}/transfers/{$domainTransfer}");
        return new Response($response, DomainTransfer::class);
    }

    /**
     * Cancels an in progress domain transfer.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#cancelDomainTransfer
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param int $domainTransfer The domain transfer id
     * @return Response The details of the domain transfer
     * @throws DnsimpleException When something goes wrong
     */
    public function cancelDomainTransfer($account, $domain, $domainTransfer): Response
    {
        $response = $this->delete("/{$account}/registrar/domains/{$domain}/transfers/{$domainTransfer}");
        return new Response($response, DomainTransfer::class);
    }

    /**
     * Renew a domain name already registered with DNSimple.
     *
     * Your account must be active for this command to complete successfully. You will be automatically charged the
     * renewal fee upon successful renewal, so please be careful with this command.t
     *
     * @see https://developer.dnsimple.com/v2/registrar/#renewDomain
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param array $attributes The domain renewal attributes. Refer to the documentation for the list of available fields.
     * @return Response The domain renewal
     * @throws DnsimpleException When something goes wrong
     */
    public function renewDomain($account, $domain, array $attributes = []): Response
    {
        $response = $this->post("/{$account}/registrar/domains/{$domain}/renewals", $attributes);
        return new Response($response, DomainRenewal::class);
    }

    /**
     * Prepare a domain for transferring out. This will unlock a domain and send the authorization code to the domain’s
     * administrative contact.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#authorizeDomainTransferOut
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function transferDomainOut($account, $domain): Response
    {
        $response = $this->post("/{$account}/registrar/domains/{$domain}/authorize_transfer_out");
        return new Response($response);
    }

    /**
     * List name servers for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/registrar/delegation/#getDomainDelegation
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @return Response The list of name servers
     * @throws DnsimpleException When something goes wrong
     */
    public function getDomainDelegation($account, $domain): Response
    {
        $response = $this->get("/{$account}/registrar/domains/{$domain}/delegation");
        return new Response($response);
    }

    /**
     * Update name servers for the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/registrar/delegation/#changeDomainDelegation
     *
     * @param int $account The account id
     * @param string $domain The domain name
     * @param array $attributes List of name servers
     * @return Response The list of name servers
     * @throws DnsimpleException When something goes wrong
     */
    public function changeDomainDelegation($account, $domain, array $attributes = []): Response
    {
        $response = $this->put("/{$account}/registrar/domains/{$domain}/delegation", $attributes);
        return new Response($response);
    }

    /**
     * Delegate to vanity name servers
     *
     * @see https://developer.dnsimple.com/v2/registrar/delegation/#changeDomainDelegationToVanity
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $attributes List of name servers
     * @return Response The list of vanity name servers
     * @throws DnsimpleException When something goes wrong
     */
    public function changeDomainDelegationToVanity($account, $domain, array $attributes =[]): Response
    {
        $response = $this->put("/{$account}/registrar/domains/{$domain}/delegation/vanity", $attributes);
        return new Response($response, VanityNameServer::class);
    }

    /**
     * Delegate from name servers
     *
     * WARNING: This method required the vanity name servers feature, that is only available for certain plans.
     * If the feature is not enabled, you will receive an HTTP 412 response code.
     *
     * @see https://developer.dnsimple.com/v2/registrar/delegation/#changeDomainDelegationFromVanity
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function changeDomainDelegationFromVanity($account, $domain): Response
    {
        $response = $this->delete("/{$account}/registrar/domains/{$domain}/delegation/vanity");
        return new Response($response);
    }

    /**
     * Enables auto renewal for the domain.
     *
     * @see https://developer.dnsimple.com/v2/registrar/auto-renewal/#enableDomainAutoRenewal
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function enableDomainAutoRenewal($account, $domain): Response
    {
        $response = $this->put("/{$account}/registrar/domains/{$domain}/auto_renewal");
        return new Response($response);
    }

    /**
     * Disables auto renewal for the domain.
     *
     * @see https://developer.dnsimple.com/v2/registrar/auto-renewal/#disableDomainAutoRenewal
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     * @throws DnsimpleException When something goes wrong
     */
    public function disableDomainAutoRenewal($account, $domain): Response
    {
        $response = $this->delete("/{$account}/registrar/domains/{$domain}/auto_renewal");
        return new Response($response);
    }

    /**
     * Get the WHOIS privacy details for a domain
     *
     * @see https://developer.dnsimple.com/v2/registrar/whois-privacy/#getWhoisPrivacy
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     * @throws DnsimpleException When something goes wrong
     */
    public function getWhoisPrivacy($account, $domain): Response
    {
        $response = $this->get("/{$account}/registrar/domains/{$domain}/whois_privacy");
        return new Response($response, WhoisPrivacy::class);
    }

    /**
     * Enable WHOIS privacy
     *
     * Note that if the WHOIS privacy is not purchased for the domain, enabling WHOIS privacy will cause the service
     * to be purchased for a period of 1 year.
     *
     * If WHOIS privacy was previously purchased and disabled, then calling this will enable the WHOIS privacy.
     *
     * @see https://developer.dnsimple.com/v2/registrar/whois-privacy/#enableWhoisPrivacy
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     * @throws DnsimpleException When something goes wrong
     */
    public function enableWhoisPrivacy($account, $domain): Response
    {
        $response = $this->put("/{$account}/registrar/domains/{$domain}/whois_privacy");
        return new Response($response, WhoisPrivacy::class);
    }
    /**
     * Disable WHOIS privacy
     *
     * Note that if the WHOIS privacy is not purchased for the domain, this method will do nothing.
     *
     * If WHOIS privacy was previously purchased and enabled, then calling this will disable the WHOIS privacy.
     *
     * @see https://developer.dnsimple.com/v2/registrar/whois-privacy/#disableWhoisPrivacy
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     * @throws DnsimpleException When something goes wrong
     */
    public function disableWhoisPrivacy($account, $domain): Response
    {
        $response = $this->delete("/{$account}/registrar/domains/{$domain}/whois_privacy");
        return new Response($response, WhoisPrivacy::class);
    }

    /**
     * Renew WHOIS privacy
     *
     * @see https://developer.dnsimple.com/v2/registrar/whois-privacy/#renewWhoisPrivacy
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     * @throws DnsimpleException When something goes wrong
     */
    public function renewWhoisPrivacy($account, $domain): Response
    {
        $response = $this->post("/{$account}/registrar/domains/{$domain}/whois_privacy/renewals");
        return new Response($response, WhoisPrivacy::class);
    }
}
