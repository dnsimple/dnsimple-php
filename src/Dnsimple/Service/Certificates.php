<?php


namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Certificate;
use Dnsimple\Struct\CertificateDownload;
use Dnsimple\Struct\CertificatePrivateKey;
use Dnsimple\Struct\CertificatePurchase;
use Dnsimple\Struct\CertificateRenewal;

/**
 * The Certificates service handles communication with the certificate related methods of the DNSimple API
 * @see https://developer.dnsimple.com/v2/certificates/
 * @package Dnsimple\Service
 */
class Certificates extends ClientService
{
    /**
     * List the certificates for a domain in the account.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#listCertificates
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of certificates for the domain
     */
    public function listCertificates($accountId, $domain, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domain}/certificates"), $options);
        return new Response($response, Certificate::class);
    }

    /**
     * Get the details of a certificate.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#getCertificate
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int $certificateId The certificate id
     * @return Response The certificate Requested
     */
    public function getCertificate($accountId, $domain, $certificateId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domain}/certificates/{$certificateId}"));
        return new Response($response, Certificate::class);
    }

    /**
     * Gets the PEM-encoded certificate, along with the root certificate and intermediate chain
     *
     * @see https://developer.dnsimple.com/v2/certificates/#downloadCertificate
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int $certificateId The certificate id
     * @return Response The certificate in the domain
     */
    public function downloadCertificate($accountId, $domain, $certificateId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domain}/certificates/{$certificateId}/download"));
        return new Response($response, CertificateDownload::class);
    }

    /**
     * Get the PEM-encoded certificate private key
     *
     * @see https://developer.dnsimple.com/v2/certificates/#getCertificatePrivateKey
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int $certificateId The certificate id
     * @return Response The PEM-encoded certificate private key
     */
    public function getCertificatePrivateKey($accountId, $domain, $certificateId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/domains/{$domain}/certificates/{$certificateId}/private_key"));
        return new Response($response, CertificatePrivateKey::class);
    }

    /**
     * Purchase a Let's Encrypt certificate
     *
     * This method creates a new certificate order. The certificate ID should be used to request the issuance of the
     * certificate using {#issue_letsencrypt_certificate}.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#purchaseLetsencryptCertificate
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param array $attributes The certificate purchase attributes. Refer to the documentation for the list of available fields.
     * @return Response The certificate purchase
     */
    public function purchaseLetsEncryptCertificate($accountId, $domain, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domain}/certificates/letsencrypt"), $attributes);
        return new Response($response, CertificatePurchase::class);
    }

    /**
     * Issue a pending Let's Encrypt certificate order.
     *
     * Note that the issuance process is async. A successful response means the issuance request has been successfully
     * acknowledged and queued for processing.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#issueLetsencryptCertificate
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int $certificateId The certificate id
     * @return Response The certificate issued
     */
    public function issueLetsencryptCertificate($accountId, $domain, $certificateId)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domain}/certificates/letsencrypt/{$certificateId}/issue"));
        return new Response($response, Certificate::class);
    }

    /**
     * Purchase a Let's Encrypt certificate renewal.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#purchaseRenewalLetsencryptCertificate
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int $certificateId The certificate id
     * @param array $attributes The renewal attributes. Refer to the documentation for the list of available fields.
     * @return Response
     */
    public function purchaseLetsencryptCertificateRenewal($accountId, $domain, $certificateId, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domain}/certificates/letsencrypt/{$certificateId}/renewals"), $attributes);
        return new Response($response, CertificateRenewal::class);
    }

    /**
     * Issue a pending Let's Encrypt certificate renewal order
     *
     * Note that the issuance process is async. A successful response means the issuance request has been
     * successfully acknowledged and queued for processing.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#issueRenewalLetsencryptCertificate
     *
     * @param int $accountId The account id
     * @param int|string $domain The domain name or id
     * @param int $certificateId The certificate id
     * @param int $renewalId The certificate renewal id
     * @return Response
     */
    public function issueLetsencryptCertificateRenewal($accountId, $domain, $certificateId, $renewalId)
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/domains/{$domain}/certificates/letsencrypt/{$certificateId}/renewals/{$renewalId}/issue"));
        return new Response($response, Certificate::class);
    }
}
