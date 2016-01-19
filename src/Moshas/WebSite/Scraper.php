<?php
namespace Moshas\WebSite;

use Loula\HttpClient;
use Loula\HttpRequest;
use Moshas\Entity;

// NO TEST
class Scraper extends HttpClient
{
    public function scrape (ScrapingDefinition $definition)
    {
        $response = $this->sendOne(new HttpRequest('GET', $definition->getUrl()));
        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($response->getBody(), 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        $xPath = new \DOMXPath($dom);
        // fixed size.
        $result = $xPath->query($definition->getFieldDefinitions()[0]->getQuery());
        if ($result === null || $result->length === 0) return array();
        $scrapingResult = array();
        for ($i = 0; $i <  $result->length; $i++) {
            $scrapingResult[] = $definition->newEntity();
            foreach ($definition->getFieldDefinitions() as $fieldDefinition) {
                $result = $xPath->query($fieldDefinition->getQuery());
                if ($result === null || $result->length === 0) continue;
                $item = $result->item($i);
                $text = $fieldDefinition->buildData($item);
                $fieldDefinition->setTo($text, $scrapingResult[$i]);
            }
        }
        return $scrapingResult;
    }
}
