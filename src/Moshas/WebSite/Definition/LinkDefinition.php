<?php
namespace Moshas\WebSite\Definition;
use Moshas\WebSite\FieldDefinition;

class LinkDefinition extends FieldDefinition
{
    private $hostName = null;
    public function __construct($query, $hostName = null)
    {
        parent::__construct($query, FieldDefinition::SETTING_TO_URL, FieldDefinition::DATA_AS_TEXT, FieldDefinition::DATA_FROM_ATTRIBUTE, 'href');
        $this->hostName = $hostName;
    }

    public function setTo($text, $entity)
    {
        if ($this->hostName && strpos($text, 'http') !== 0) {
            $text = $this->hostName . $text;
        }
        parent::setTo($text, $entity);
    }
}