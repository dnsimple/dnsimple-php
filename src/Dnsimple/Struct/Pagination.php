<?php


namespace Dnsimple\Struct;

/**
 * The pagination object
 *
 * Any API endpoint that returns a list of items requires pagination. By default we will return 30 records from any
 * listing endpoint.
 *
 * If an API endpoint returns a list of items, then it will include a pagination object that contains pagination
 * information.
 *
 * @see https://developer.dnsimple.com/v2/#pagination
 * @package Dnsimple\Struct
 */
class Pagination
{
    /**
     * @var int The page currently returned (default: 1)
     */
    public int $currentPage;
    /**
     * @var int The number of entries returned per page (default: 30)
     */
    public int $perPage;
    /**
     * @var int The total number of entries available in the entire collection
     */
    public int $totalEntries;
    /**
     * @var int The total number of pages available given the current per_page value
     */
    public int $totalPages;

    public function __construct($data)
    {
        $this->currentPage = $data->current_page;
        $this->perPage = $data->per_page;
        $this->totalEntries = $data->total_entries;
        $this->totalPages = $data->total_pages;
    }
}
