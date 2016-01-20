<?php
namespace Moshas\WebSite\Definition;
use Moshas\WebSite\TextField;

class TitleDefinition extends TextField
{
    public function setTo($text, $entity)
    {
        $entity->setSubject($text);
    }

}