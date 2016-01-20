<?php
namespace Moshas\WebSite\Definition;
use Moshas\WebSite\FieldDataBuilder;
use Moshas\WebSite\FieldDefinition;

class BodyDefinition extends FieldDefinition implements FieldDataBuilder
{
    public function __construct($query)
    {
        parent::__construct($query, $this);
    }

    public function setTo($text, $entity)
    {
        $entity->setBody($text);
    }

    public function build($item)
    {
        return $item->textContent;
    }
}