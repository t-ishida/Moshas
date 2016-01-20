<?php
namespace Moshas\WebSite\Definition;

use Moshas\WebSite\TextField;

class DateDefinition extends TextField
{
    public function setTo($text, $entity)
    {
        $entity->setCreatedAt($text);
    }
}