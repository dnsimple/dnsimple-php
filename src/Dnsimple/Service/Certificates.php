<?php


namespace Dnsimple\Service;


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
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of certificates for the domain
     */
    public function listCertificates($account, $domain, array $options = [])
    {
        $response = $this->get("/{$account}/domains/{$domain}/certificates", $options);

        return new Response($response, Certificate::class);
    }

    /**
     * Get the details of a certificate.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#getCertificate
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $certificate The certificate id
     * @return Response The certificate Requested
     */
    public function getCertificate($account, $domain, $certificate)
    {
        $response = $this->get("/{$account}/domains/{$domain}/certificates/{$certificate}");
        return new Response($response, Certificate::class);
    }

    /**
     * Gets the PEM-encoded certificate, along with the root certificate and intermediate chain
     *
     * @see https://developer.dnsimple.com/v2/certificates/#downloadCertificate
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $certificate The certificate id
     * @return Response The certificate in the domain
     */
    public function downloadCertificate($account, $domain, $certificate)
    {
        $response = $this->get("/{$account}/domains/{$domain}/certificates/{$certificate}/download");
        return new Response($response, CertificateDownload::class);
    }

    /**
     * Get the PEM-encoded certificate private key
     *
     * @see https://developer.dnsimple.com/v2/certificates/#getCertificatePrivateKey
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $certificate The certificate id
     * @return Response The PEM-encoded certificate private key
     */
    public function getCertificatePrivateKey($account, $domain, $certificate)
    {
        $response = $this->get("/{$account}/domains/{$domain}/certificates/{$certificate}/private_key");
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
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param array $attributes The certificate purchase attributes. Refer to the documentation for the list of available fields.
     * @return Response The certificate purchase
     */
    public function purchaseLetsEncryptCertificate($account, $domain, array $attributes = [])
    {
        $response = $this->post("/{$account}/domains/{$domain}/certificates/letsencrypt", $attributes);
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
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $certificate The certificate id
     * @return Response The certificate issued
     */
    public function issueLetsencryptCertificate($account, $domain, $certificate)
    {
        $response = $this->post("/{$account}/domains/{$domain}/certificates/letsencrypt/{$certificate}/issue");
        return new Response($response, Certificate::class);
    }

    /**
     * Purchase a Let's Encrypt certificate renewal.
     *
     * @see https://developer.dnsimple.com/v2/certificates/#purchaseRenewalLetsencryptCertificate
     *
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $certificate The certificate id
     * @param array $attributes The renewal attributes. Refer to the documentation for the list of available fields.
     * @return Response
     */
    public function purchaseLetsencryptCertificateRenewal($account, $domain, $certificate, array $attributes = [])
    {
        $response = $this->post("/{$account}/domains/{$domain}/certificates/letsencrypt/{$certificate}/renewals", $attributes);
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
     * @param int $account The account id
     * @param int|string $domain The domain name or id
     * @param int $certificate The certificate id
     * @param int $certificateRenewal The certificate renewal id
     * @return Response
     */
    public function issueLetsencryptCertificateRenewal($account, $domain, $certificate, $certificateRenewal)
    {
        $response = $this->post("/{$account}/domains/{$domain}/certificates/letsencrypt/{$certificate}/renewals/{$certificateRenewal}/issue");
        return new Response($response, Certificate::class);
    }
}
