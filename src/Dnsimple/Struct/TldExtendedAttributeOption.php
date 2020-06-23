<?php


namespace Dnsimple\Struct;

/**
 * Represents a single option you can assign to an extended attributes
 * @package Dnsimple\Struct
 */
class TldExtendedAttributeOption
{
    /**
     * @var string The option name
     */
    public string $title;
    /**
     * @var string The option value
     */
    public string $value;
    /**
     * @var string A long description of the option
     */
    public string $description;

    /**
     * TldExtendedAttributeOption constructor.
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->title = $data->title;
        $this->value = $data->value;
        $this->description = $data->description;
    }
}
