<?php


namespace Dnsimple\Struct;

/**
 * Represents the query parameters that produced a DNS Analytics result
 *
 * @package Dnsimple\Struct
 */
class DnsAnalyticsQuery
{
    /**
     * @var int The account id
     */
    public $accountId;
    /**
     * @var string|null The start date of the query
     */
    public $startDate;
    /**
     * @var string|null The end date of the query
     */
    public $endDate;
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
    public $perPage;
    /**
     * @var string|null The groupings
     */
    public $groupings;

    public function __construct($data)
    {
        $this->accountId = $data->account_id;
        $this->startDate = $data->start_date;
        $this->endDate = $data->end_date;
        $this->sort = $data->sort;
        $this->page = $data->page;
        $this->perPage = $data->per_page;
        $this->groupings = $data->groupings;
    }
}
