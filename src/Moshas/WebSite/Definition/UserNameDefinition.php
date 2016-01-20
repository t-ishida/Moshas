<?php
/**
 * Date: 2016/01/20
 * Time: 10:58
 */

namespace Moshas\WebSite\Definition;

use Moshas\WebSite\FieldDataBuilder;
use Moshas\WebSite\FieldDefinition;

class UserNameDefinition extends FieldDefinition implements FieldDataBuilder
{
    public function __construct($query)
    {
        parent::__construct($query, $this);
    }

    public function setTo($text, $entity)
    {
        $entity->setUserName($text);
    }

    public function build($item)
    {
        return $item->textContent;
    }
}