<?php
namespace Moshas\WebSite\Definition;

use Moshas\WebSite\TextField;

class BodyDefinition extends TextField
{


    public function setTo($text, $entity)
    {
        $entity->setBody($text);
    }

}