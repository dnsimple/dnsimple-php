<?php

namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Zone;
use Dnsimple\Struct\ZoneDistribution;
use Dnsimple\Struct\ZoneFile;
use Dnsimple\Struct\ZoneRecord;

/**
 * The Zones Service handles the zones endpoint of the DNSimple API.
 *
 * @see https://developer.dnsimple.com/v2/zones
 * @package Dnsimple\Service
 */
class ZonesService extends ClientService
{
    /**
     * Lists the zones in the account.
     *
     * @see https://developer.dnsimple.com/v2/zones/#listZones
     *
     * @param int $accountId The account id
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of zones requested
     */
    public function listZones($accountId, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/zones"), $options);
        return new Response($response, Zone::class);
    }

    /**
     * Gets a zone from the account
     *
     * @see https://developer.dnsimple.com/v2/zones/#getZone
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @return Response The zone requested
     */
    public function getZone($accountId, $zone)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/zones/{$zone}"));
        return new Response($response, Zone::class);
    }

    /**
     * Gets a zone file from the account
     *
     * @see https://developer.dnsimple.com/v2/zones/#getZoneFile
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @return Response The zone file requested
     */
    public function getZoneFile($accountId, $zone)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/zones/{$zone}/file"));
        return new Response($response, ZoneFile::class);
    }

    /**
     * Checks if a zone change is fully distributed to all DNSimple name servers across the globe.
     *
     * WARNING: This feature can’t be tested in our Sandbox environment.
     *
     * @see https://developer.dnsimple.com/v2/zones/#checkZoneDistribution
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @return Response The zone distribution
     */
    public function checkZoneDistribution($accountId, $zone)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/zones/{$zone}/distribution"));
        return new Response($response, ZoneDistribution::class);
    }

    /**
     * Lists the zone records in the account
     *
     * @see https://developer.dnsimple.com/v2/zones/records/#listZoneRecords
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @param array $options key/value options to sort and filter the results
     * @return Response The list of zone records in the account
     */
    public function listRecords($accountId, $zone, array $options = [])
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/zones/{$zone}/records"), $options);
        return new Response($response, ZoneRecord::class);
    }

    /**
     * Create a record for the zone in the account
     *
     * @see https://developer.dnsimple.com/v2/zones/records/#createZoneRecord
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @param array $attributes The zone record attributes. Refer to the documentation for the list of available fields.
     * @return Response The newly created zone record
     */
    public function createRecord($accountId, $zone, array $attributes = [])
    {
        $response = $this->client->post(Client::versioned("/{$accountId}/zones/{$zone}/records"), $attributes);
        return new Response($response, ZoneRecord::class);
    }

    /**
     * Gets a zone record from the account
     *
     * @see https://developer.dnsimple.com/v2/zones/records/#getZoneRecord
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @param int $recordId The record id
     * @return Response The zone record requested
     */
    public function getRecord($accountId, $zone, $recordId)
    {
        $response = $this->client->get(Client::versioned("/{$accountId}/zones/{$zone}/records/{$recordId}"));
        return new Response($response, ZoneRecord::class);
    }

    /**
     * Updates a zone record in the account.
     *
     * @see https://developer.dnsimple.com/v2/zones/records/#updateZoneRecord
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @param int $recordId The record id
     * @param array $attributes The zone record attributes. Refer to the documentation for the list of available fields.
     * @return Response The updated zone record
     */
    public function updateRecord($accountId, $zone, $recordId, $attributes)
    {
        $response = $this->client->patch(Client::versioned("/{$accountId}/zones/{$zone}/records/{$recordId}"), $attributes);
        return new Response($response, ZoneRecord::class);
    }

    /**
     * Deletes a zone record from the account.
     *
     * WARNING: this cannot be undone.
     *
     * @see https://developer.dnsimple.com/v2/zones/records/#deleteZoneRecord
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @param int $recordId The record id
     * @return Response An empty response
     */
    public function deleteRecord($accountId, $zone, $recordId)
    {
        $response = $this->client->delete(Client::versioned("/{$accountId}/zones/{$zone}/records/{$recordId}"));
        return new Response($response);
    }

    /**
     * Checks if a zone record is fully distributed to all DNSimple name servers across the globe.
     *
     * WARNING: This feature can’t be tested in our Sandbox environment.
     *
     * @see https://developer.dnsimple.com/v2/zones/records/#checkZoneRecordDistribution
     *
     * @param int $accountId The account id
     * @param string $zone The zone name
     * @param int $recordId The record id
     * @return Response The zone record distribution
     */
    public function checkZoneRecordDistribution($accountId, $zone, $recordId) {
        $response = $this->client->get(Client::versioned("/{$accountId}/zones/{$zone}/records/{$recordId}/distribution"));
        return new Response($response, ZoneDistribution::class);
    }
}
