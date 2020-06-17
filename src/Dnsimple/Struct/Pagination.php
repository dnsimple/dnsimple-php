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
    public int $current_page;
    /**
     * @var int The number of entries returned per page (default: 30)
     */
    public int $per_page;
    /**
     * @var int The total number of entries available in the entire collection
     */
    public int $total_entries;
    /**
     * @var int The total number of pages available given the current per_page value
     */
    public int $total_pages;

    public function __construct($data)
    {
        $this->current_page = $data->current_page;
        $this->per_page = $data->per_page;
        $this->total_entries = $data->total_entries;
        $this->total_pages = $data->total_pages;
    }
}
