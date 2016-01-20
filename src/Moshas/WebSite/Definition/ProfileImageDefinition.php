<?php
/**
 * Date: 2016/01/20
 * Time: 10:59
 */

namespace Moshas\WebSite\Definition;

use Moshas\WebSite\FieldDataBuilder;
use Moshas\WebSite\FieldDefinition;

class ProfileImageDefinition extends FieldDefinition implements FieldDataBuilder
{
    private $hostName = null;
    public function __construct($query, $hostName = null)
    {
        parent::__construct($query, $this);
        $this->hostName = $hostName;
    }

    public function setTo($text, $entity)
    {
        $entity->setProfileImageUrl($text);
    }

    public function build($item)
    {
        $text = '';
        $attributes = $item->attributes;
        if ($attributes === null || $attributes->length === 0) return $text;
        for ($j = 0; $j < $attributes->length; $j++) {
            if ($attributes->item($j)->name !== 'src') continue;
            $text .= $attributes->item($j)->nodeValue;
        }
        if ($this->hostName && strpos($text, 'http') !== 0) {
            $text = $this->hostName . $text;
        }
        return $text;
    }
}