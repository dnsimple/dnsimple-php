<?php

namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\DomainCheck;
use Dnsimple\Struct\DomainPremiumPrice;
use Dnsimple\Struct\DomainRegistration;
use Dnsimple\Struct\DomainRenewal;
use Dnsimple\Struct\DomainTransfer;
use Dnsimple\Struct\WhoisPrivacy;

/**
 * The Registrar Service handles the registrar endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/registrar
 * @package Dnsimple
 */
class RegistrarService extends ClientService
{
    /**
     * Checks whether a domain is available to be registered.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#checkDomain
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @return Response The domain check result
     */
    public function checkDomain($accountId, $domain)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/registrar/domains/{$domain}/check"));
        return new Response($response, DomainCheck::class);
    }

    /**
     * Get the premium price for a domain.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#getDomainPremiumPrice
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @param string $action Optional action between "registration", "renewal", and "transfer". If omitted, it defaults to "registration".
     * @return Response The domain premium price
     */
    public function getDomainPremiumPrice($accountId, $domain, $action = "registration")
    {
        $options = ["action" => $action];
        $response = $this->client->get(Client::versioned("/{$accountId}/registrar/domains/{$domain}/premium_price"), $options);
        return new Response($response, DomainPremiumPrice::class);
    }

    /**
     * Registers a domain
     *
     * @see https://developer.dnsimple.com/v2/registrar/#registerDomain
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @param array $attributes The domain registration attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly registered domain
     */
    public function registerDomain($accountId, $domain, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/registrar/domains/{$domain}/registrations"), $attributes);
        return new Response($response, DomainRegistration::class);
    }

    /**
     * Starts the transfer of a domain to DNSimple
     *
     * @see https://developer.dnsimple.com/v2/registrar/#transferDomain
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @param array $attributes The domain transfer attributes. Refer to the documentation for the list of available fields.
     * @return Response The domain transfer
     */
    public function transferDomain($accountId, $domain, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/registrar/domains/{$domain}/transfers"), $attributes);
        return new Response($response, DomainTransfer::class);
    }

    /**
     * Retrieves the details of an existing domain transfer.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#getDomainTransfer
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @param int $domainTransfer The domain transfer id
     * @return Response The details of an existing domain transfer
     */
    public function getDomainTransfer($accountId, $domain, $domainTransfer)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/registrar/domains/{$domain}/transfers/{$domainTransfer}"));
        return new Response($response, DomainTransfer::class);
    }

    /**
     * Cancels an in progress domain transfer.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#cancelDomainTransfer
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @param int $domainTransfer The domain transfer id
     * @return Response The details of the domain transfer
     */
    public function cancelDomainTransfer($accountId, $domain, $domainTransfer)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/registrar/domains/{$domain}/transfers/{$domainTransfer}"));
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
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @param array $attributes The domain renewal attributes. Refer to the documentation for the list of available fields.
     * @return Response The domain renewal
     */
    public function renewDomain($accountId, $domain, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/registrar/domains/{$domain}/renewals"), $attributes);
        return new Response($response, DomainRenewal::class);
    }

    /**
     * Prepare a domain for transferring out. This will unlock a domain and send the authorization code to the domain’s
     * administrative contact.
     *
     * @see https://developer.dnsimple.com/v2/registrar/#authorizeDomainTransferOut
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @return Response An empty response
     */
    public function transferDomainOut($accountId, $domain)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/registrar/domains/{$domain}/authorize_transfer_out"));
        return new Response($response);
    }

    /**
     * List name servers for the domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/registrar/delegation/#getDomainDelegation
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @return Response The list of name servers
     */
    public function getDomainDelegation($accountId, $domain)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/registrar/domains/{$domain}/delegation"));
        return new Response($response);
    }

    /**
     * Update name servers for the domain in the account
     *
     * @see https://developer.dnsimple.com/v2/registrar/delegation/#changeDomainDelegation
     *
     * @param int $accountId The account id
     * @param string $domain The domain name
     * @param array $attributes List of name servers
     * @return Response The list of name servers
     */
    public function changeDomainDelegation($accountId, $domain, $attributes)
    {
        $response = $this->client->put(Client::versioned("/{$accountId}/registrar/domains/{$domain}/delegation"), $attributes);
        return new Response($response);
    }

    /**
     * Delegate from name servers
     *
     * WARNING: This method required the vanity name servers feature, that is only available for certain plans.
     * If the feature is not enabled, you will receive an HTTP 412 response code.
     *
     * @see https://developer.dnsimple.com/v2/registrar/delegation/#changeDomainDelegationFromVanity
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     */
    public function changeDomainDelegationFromVanity($accountId, $domain)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/registrar/domains/{$domain}/delegation/vanity"));
        return new Response($response);
    }

    /**
     * Enables auto renewal for the domain.
     *
     * @see https://developer.dnsimple.com/v2/registrar/auto-renewal/#enableDomainAutoRenewal
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     */
    public function enableDomainAutoRenewal($accountId, $domain)
    {
        $response = $this->client->put(Client::versioned("/{$accountId}/registrar/domains/{$domain}/auto_renewal"));
        return new Response($response);
    }

    /**
     * Disables auto renewal for the domain.
     *
     * @see https://developer.dnsimple.com/v2/registrar/auto-renewal/#disableDomainAutoRenewal
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response An empty response
     */
    public function disableDomainAutoRenewal($accountId, $domain)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/registrar/domains/{$domain}/auto_renewal"));
        return new Response($response);
    }

    /**
     * Get the WHOIS privacy details for a domain
     *
     * @see https://developer.dnsimple.com/v2/registrar/whois-privacy/#getWhoisPrivacy
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     */
    public function getWhoisPrivacy($accountId, $domain)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/registrar/domains/{$domain}/whois_privacy"));
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
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     */
    public function enableWhoisPrivacy($accountId, $domain)
    {
        $response = $this->client->put(Client::versioned("/{$accountId}/registrar/domains/{$domain}/whois_privacy"));
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
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     */
    public function disableWhoisPrivacy($accountId, $domain)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/registrar/domains/{$domain}/whois_privacy"));
        return new Response($response, WhoisPrivacy::class);
    }

    /**
     * Renew WHOIS privacy
     *
     * @see https://developer.dnsimple.com/v2/registrar/whois-privacy/#renewWhoisPrivacy
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @return Response The whois privacy details
     */
    public function renewWhoisPrivacy($accountId, $domain)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/registrar/domains/{$domain}/whois_privacy/renewals"));
        return new Response($response, WhoisPrivacy::class);
    }
}
