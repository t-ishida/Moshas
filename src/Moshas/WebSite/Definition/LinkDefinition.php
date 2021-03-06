<?php
namespace Moshas\WebSite\Definition;
use Moshas\WebSite\FieldDataBuilder;
use Moshas\WebSite\FieldDefinition;

class LinkDefinition extends FieldDefinition implements FieldDataBuilder
{
    private $hostName = null;
    public function __construct($query, $hostName = null)
    {
        parent::__construct($query, $this);
        $this->hostName = $hostName;
    }

    public function setTo($text, $entity)
    {
        $entity->setUrl($text);
    }

    public function build($item)
    {
        $text = '';
        $attributes = $item->attributes;
        if ($attributes === null || $attributes->length === 0) return $text;
        for ($j = 0; $j < $attributes->length; $j++) {
            if ($attributes->item($j)->name !== 'href') continue;
            $text .= $attributes->item($j)->nodeValue;
        }
        if ($this->hostName && strpos($text, 'http') !== 0) {
            $text = $this->hostName . $text;
        }
        return $text;
    }
}