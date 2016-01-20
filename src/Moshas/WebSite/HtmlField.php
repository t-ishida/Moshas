<?php
namespace Moshas\WebSite;


abstract class HtmlField extends FieldDefinition implements FieldDataBuilder
{
    public function build($item)
    {
        return $item->saveHTML();
    }
}