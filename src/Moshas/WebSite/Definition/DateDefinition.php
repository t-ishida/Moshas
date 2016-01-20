<?php
/**
 * Date: 2016/01/20
 * Time: 10:45
 */

namespace Moshas\WebSite\Definition;


use Moshas\WebSite\FieldDataBuilder;
use Moshas\WebSite\FieldDefinition;

class DateDefinition extends FieldDefinition implements FieldDataBuilder
{
    public function __construct($query)
    {
        parent::__construct($query, $this);
    }

    public function setTo($text, $entity)
    {
        $entity->setCreatedAt($text);
    }

    public function build($item)
    {
        return $item->textContent;
    }
}