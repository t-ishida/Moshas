<?php
namespace Moshas\WebSite;


use Moshas\Entity;

class ScrapingDefinition
{
    private $url = null;
    private $fieldDefinitions = null;


    public function __construct($url, array $fieldDefinitions)
    {
        $this->url = $url;
        $this->fieldDefinitions = $fieldDefinitions;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return FieldDefinition[]
     */
    public function getFieldDefinitions()
    {
        return $this->fieldDefinitions;
    }

    public function newEntity ()
    {
        return new Entity();
    }
}