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

    public function getSettingTo()
    {
        return $this->innerField->getSettingTo();
    }

    public function getDataAs()
    {
        return $this->innerField->getDataAs();
    }

    public function getDataFrom()
    {
        return $this->innerField->getDataFrom();
    }

    public function getAttributeName()
    {
        return $this->innerField->getAttributeName();
    }

    public function setTo($text, $entity)
    {
        $fn = $this->decorator;
        $this->innerField->setTo($fn($text), $entity);
    }

    public function buildData($item)
    {
        return $this->innerField->buildData($item);
    }
}