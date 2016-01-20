<?php
namespace Moshas\WebSite;


abstract class TextField extends FieldDefinition implements FieldDataBuilder
{
    public function __construct($query)
    {
        parent::__construct($query, $this);
    }

    public function build($item)
    {
        return $item->textContent;
    }
}