<?php


namespace Dnsimple\Struct;

/**
 * Represents a Service in DNSimple
 * @package Dnsimple\Struct
 */
class Service
{
    /**
     * @var int The service ID in DNSimple
     */
    public $id;
    /**
     * @var string The service name
     */
    public $name;
    /**
     * @var string A string ID for the service
     */
    public $sid;
    /**
     * @var string The service description
     */
    public $description;
    /**
     * @var string|null The service setup description
     */
    public $setupDescription;
    /**
     * @var bool Whether the service requires extra setup
     */
    public $requiresSetup;
    /**
     * @var string|null The default subdomain where the service will be applied
     */
    public $defaultSubdomain;
    /**
     * @var string When the service was created in DNSimple
     */
    public $createdAt;
    /**
     * @var string When the service was last updated in DNSimple
     */
    public $updatedAt;
    /**
     * @var array|ServiceSetting[] The array of settings to setup this service, if setup is required.
     */
    public $settings;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->sid = $data->sid;
        $this->description = $data->description;
        $this->setupDescription = $data->setup_description;
        $this->requiresSetup = $data->requires_setup;
        $this->defaultSubdomain = $data->default_subdomain;
        $this->createdAt = $data->created_at;
        $this->updatedAt = $data->updated_at;
        $this->settings = array_map(function($args) { return new ServiceSetting($args); }, $data->settings);

    }
}
