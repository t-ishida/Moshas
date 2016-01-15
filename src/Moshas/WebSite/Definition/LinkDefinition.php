<?php
namespace Moshas\WebSite\Definition;
use Moshas\WebSite\FieldDefinition;

class LinkDefinition extends FieldDefinition
{
    public function __construct($query)
    {
        parent::__construct($query, FieldDefinition::SETTING_TO_URL, FieldDefinition::DATA_AS_TEXT, FieldDefinition::DATA_FROM_ATTRIBUTE, 'href');
    }
}