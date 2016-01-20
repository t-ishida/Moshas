<?php
namespace Moshas\WebSite\Definition;
use Moshas\WebSite\TextField;

class UserNameDefinition extends TextField
{

    public function setTo($text, $entity)
    {
        $entity->setUserName($text);
    }

}