<?php


namespace Dnsimple\Service;


use Dnsimple\Client;
use Dnsimple\Response;
use Dnsimple\Struct\Zone;
use Dnsimple\Struct\ZoneDistribution;
use Dnsimple\Struct\ZoneFile;

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
     *      - name_like: Only include zones containing given string (i.e. ['name_like' => 'example.com'] )
     *  - sorting:
     *    Comma separated key-value pairs: the name of a field and the order criteria (asc for ascending and desc for
     *    descending).
     *    Sort criteria:
     *      - id: Sort zones by ID (i.e. 'id:asc')
     *      - name: Sort zones by name (alphabetical order) (i.e. 'name:desc')
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
}
