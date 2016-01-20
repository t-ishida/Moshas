<?php
/**
 * Date: 2016/01/19
 * Time: 20:03
 */

namespace Moshas\WebSite;

class FieldDecorator extends FieldDefinition
{
    private $innerField = null;
    private $decorator = null;

    public function __construct(FieldDefinition $innerField, \Closure $decorator)
    {
        $this->innerField = $innerField;
        $this->decorator = $decorator;
    }

    public function getQuery()
    {
        return $this->innerField->getQuery();
    }


    public function setTo($text, $entity)
    {
        $this->innerField->setTo($text, $entity);
    }

    public function buildData($item)
    {
        $fn = $this->decorator;
        $text = $this->innerField->buildData($item);
        return $fn($text);
    }
}