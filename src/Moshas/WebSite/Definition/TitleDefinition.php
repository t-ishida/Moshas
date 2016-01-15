<?php
namespace Moshas\WebSite\Definition;
use Moshas\WebSite\FieldDefinition;

class TitleDefinition extends FieldDefinition
{
    public function __construct($query)
    {
        parent::__construct($query, FieldDefinition::SETTING_TO_SUBJECT, FieldDefinition::DATA_AS_TEXT, FieldDefinition::DATA_FROM_TEXT);
    }
}