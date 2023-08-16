<?php

namespace Dnsimple\Struct;

class ExtendedAttribute
{
    /**
     * @var string The attribute name
     */
    public $name;
    /**
     * @var string The attribute title
     */
    public $title;
    /**
     * @var string The attribute description
     */
    public $description;
    /**
     * @var bool Whether the attribute is required
     */
    public $required;
    /**
     * @var array The attribute options
     */
    public $options;

    public function __construct($data)
    {
        $this->name = $data["name"];
        $this->title = $data["title"];
        $this->description = $data["description"];
        $this->required = $data["required"];
        $this->options = $data["options"];
    }
}
