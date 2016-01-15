<?php
namespace Moshas\WebSite;

use Loula\HttpClient;
use Loula\HttpRequest;
use Moshas\Entity;

class Scraper extends HttpClient
{
    public function scrape (ScrapingDefinition $definition)
    {
        $response = $this->sendOne(new HttpRequest('GET', $definition->getUrl()));
        $scrapingResult = array();

        $dom = new \DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML(mb_convert_encoding($response->getBody(), 'HTML-ENTITIES', 'UTF-8'));
        $xPath = new \DOMXPath($dom);
        // fixed size.
        $result = $xPath->query($definition->getFieldDefinitions()[0]->getQuery());
        if ($result === null || $result->length === 0)  return $scrapingResult;
        for ($i = 0; $i <  $result->length; $i++) {
            $scrapingResult[] = new Entity();
        }

        foreach ($definition->getFieldDefinitions() as $fieldDefinition) {
            $result = $xPath->query($fieldDefinition->getQuery());
            if ($result === null || $result->length === 0) continue;
            for ($i = 0; $i < $result->length; $i++) {
                $text = '';
                $item = $result->item($i);
                if ($fieldDefinition->getDataFrom() === FieldDefinition::DATA_FROM_TEXT) {
                    if ($fieldDefinition->getDataAs() === FieldDefinition::DATA_AS_HTML) {
                        $text = $item->nodeValue;
                    } elseif ($fieldDefinition->getDataAs() === FieldDefinition::DATA_AS_TEXT) {
                        $text = $item->textContent;
                    }
                } elseif ($fieldDefinition->getDataFrom() === FieldDefinition::DATA_FROM_ATTRIBUTE) {
                    $attributes = $item->attributes;
                    if ($attributes === null || $attributes->length === 0) continue;
                    for ($j = 0; $j < $attributes->length; $j++) {
                        if ($attributes->item($j)->name !== $fieldDefinition->getAttributeName()) continue;
                        $text .= $attributes->item($j)->nodeValue;
                    }
                }
                if ($fieldDefinition->getSettingTo() === FieldDefinition::SETTING_TO_BODY) {
                    $scrapingResult[$i]->setBody($text);
                } elseif ($fieldDefinition->getSettingTo() === FieldDefinition::SETTING_TO_SUBJECT) {
                    $scrapingResult[$i]->setSubject($text);
                } elseif ($fieldDefinition->getSettingTo() === FieldDefinition::SETTING_TO_URL) {
                    $scrapingResult[$i]->setUrl($text);
                } elseif ($fieldDefinition->getSettingTo() === FieldDefinition::SETTING_TO_DATE) {
                    $scrapingResult[$i]->setCreatedAt($text);
                }
            }
        }
        $dom = null;
        $xPath = null;
        return $scrapingResult;
    }
}
