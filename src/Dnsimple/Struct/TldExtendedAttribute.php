<?php


namespace Dnsimple\Struct;

/**
 * Represents an extended attributes supported or required by a specific TLD
 * @package Dnsimple\Struct
 */
class TldExtendedAttribute
{
    /**
     * @var string The extended attribute name
     */
    public string $name;
    /**
     * @var string A description of the extended attribute
     */
    public ?string $description;
    /**
     * @var bool True if the extended attribute is required
     */
    public bool $required;
    /**
     * @var array|TldExtendedAttributeOption[] The list of options with possible values for the extended attribute
     */
    public array $options;

    public function __construct($data)
    {
        $this->name = $data->name;
        $this->description = $data->description;
        $this->required = $data->required;
        $this->options = array_map(function($args) { return new TldExtendedAttributeOption($args); }, $data->options);
    }
}
