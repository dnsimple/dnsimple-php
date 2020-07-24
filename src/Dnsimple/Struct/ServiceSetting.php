<?php


namespace Dnsimple\Struct;

/**
 * Represents a single group of settings for a DNSimple Service
 * @package Dnsimple\Struct
 */
class ServiceSetting
{
    /**
     * @var string The setting name
     */
    public $name;
    /**
     * @var string The setting label
     */
    public $label;
    /**
     * @var string A suffix to be appended to the setting value
     */
    public $append;
    /**
     * @var string The setting description
     */
    public $description;
    /**
     * @var string An example of the setting value
     */
    public $example;
    /**
     * @var bool Whether the setting requires a password
     */
    public $password;

    public function __construct($data)
    {
        $this->name = $data->name;
        $this->label = $data->label;
        $this->append = $data->append;
        $this->description = $data->description;
        $this->example = $data->example;
        $this->password = $data->password;
    }
}
