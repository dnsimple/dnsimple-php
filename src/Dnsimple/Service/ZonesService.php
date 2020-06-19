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
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible options:
     *  - filters:
     *      - name_like: Only include zones containing given string (i.e. ["name_like" => "example.com"] )
     *  - sorting:
     *    Comma separated key-value pairs: the name of a field and the order criteria (asc for ascending and desc for
     *    descending). ["sort" => "sort criteria here"]
     *    Sort criteria:
     *      - id: Sort zones by ID (i.e. "id:asc")
     *      - name: Sort zones by name (alphabetical order) (i.e. "name:desc")
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
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
     * @param array $options Makes it possible to ask only for the exact subset of data that you you’re looking for.
     *
     * Possible options:
     *  - filters:
     *      - name_like: Only include records containing given string (i.e. ["name_like" => "example.com"] )
     *      - name: Only include records with name equal to given string (i.e. ["name" => "example.com"] )
     *      - type: Only include records with record type equal to given string (i.e. ["type" => "SOA"] )
     *  - sorting:
     *    Comma separated key-value pairs: the name of a field and the order criteria (asc for ascending and desc for
     *    descending).  ["sort" => "sort criteria here"]
     *    Sort criteria:
     *      - id: Sort records by ID (i.e. "id:asc")
     *      - name: Sort records by name (alphabetical order) (i.e. "name:desc")
     *      - content: Sort records by content (i.e. "content:asc")
     *      - type: Sort records by type (i.e. "type:desc")
     *  - pagination:
     *      - page: The page to return (default: 1)
     *      - per_page: The number of entries to return per page (default: 30, maximum: 100)
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
     * @param array $attributes The zone record attributes
     *                          - name: Required. The record name, without the domain. The domain will be automatically
     *                                  appended. Use an empty string to create a record for the apex.
     *                          - type: Required
     *                          - content: Required
     *                          - ttl
     *                          - priority
     *                          - regions
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
     * @param array $attributes The zone record attributes
     *                          - name: The record name, without the domain. The domain will be automatically
     *                                  appended. Use an empty string to create a record for the apex.
     *                          - content
     *                          - ttl
     *                          - priority
     *                          - regions
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
