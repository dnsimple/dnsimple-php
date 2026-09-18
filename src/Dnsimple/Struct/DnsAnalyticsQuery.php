<?php


namespace Dnsimple\Struct;

/**
 * Represents the query parameters that produced a DNS Analytics result
 * @package Dnsimple\Struct
 */
class DnsAnalyticsQuery
{
    /**
     * @var int The account id
     */
    public $account_id;
    /**
     * @var string|null The start date of the query
     */
    public $start_date;
    /**
     * @var string|null The end date of the query
     */
    public $end_date;
    /**
     * @var string The sort policy
     */
    public $sort;
    /**
     * @var int The page
     */
    public $page;
    /**
     * @var int The number of entries per page
     */
    public $per_page;
    /**
     * @var string|null The groupings
     */
    public $groupings;

    public function __construct($data)
    {
        $this->account_id = $data->account_id;
        $this->start_date = $data->start_date;
        $this->end_date = $data->end_date;
        $this->sort = $data->sort;
        $this->page = $data->page;
        $this->per_page = $data->per_page;
        $this->groupings = $data->groupings;
    }
}
