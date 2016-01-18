<?php
/**
 * Date: 2016/01/18
 * Time: 17:27
 */

namespace Moshas\WebSite\Pipe;


use Moshas\Pipe;
use Moshas\WebSite\FieldDefinition;
use Moshas\WebSite\Scraper;
use Moshas\WebSite\ScrapingDefinition;

class WhileToNext extends Pipe
{
    private $scraper = null;
    private $fieldDefinitions = null;

    public function __construct(Scraper $scraper, array $fieldDefinitions, $next = null)
    {
        parent::__construct($next);
        $this->scraper = $scraper;
        $this->fieldDefinitions = $fieldDefinitions;
    }

    public function work($src)
    {
        $result = $src;
        $urls = array();
        foreach ($src as $entity) {
            $urls[] = $entity->getUrl();
        }
        $urls = array_unique($urls);
        foreach($urls as $url)  {
            foreach ($this->scraper->scrape(new ScrapingDefinition($url, $this->fieldDefinitions)) as $article) {
                foreach ($this->work(array($article)) as $article2) {
                    $result[] = $article2;
                }
            }
        }
        return $result;
    }
}