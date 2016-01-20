<?php
namespace Moshas\WebSite;


abstract class FieldDefinition
{
    private $query = null;
    private $dataBuilder = null;

    /**
     * ScrapingDefinition constructor.
     * @param null $query
     * @param FieldDataBuilder|null $dataBuilder
     */
    public function __construct($query, FieldDataBuilder $dataBuilder = null)
    {
        $this->query = $query;
        $this->dataBuilder = $dataBuilder;
    }

    /**
     * @return null
     */
    public function getQuery()
    {
        return $this->query;
    }


    public function buildData($item)
    {
        return $this->dataBuilder->build($item);
    }

    abstract public function setTo($text, $entity);
}