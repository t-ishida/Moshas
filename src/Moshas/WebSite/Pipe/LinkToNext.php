<?php
namespace Moshas\WebSite\Pipe;


use Moshas\Pipe;
use Moshas\WebSite\Scraper;
use Moshas\WebSite\ScrapingDefinition;

class LinkToNext extends Pipe
{
    private $scraper = null;
    private $definitions = null;
    public function __construct(Scraper $scraper, array $definitions, $next)
    {
        parent::__construct($next);
        $this->scraper = $scraper;
        $this->definitions = $definitions;
    }

    public function work($src)
    {
        $result = array();
        $urls = array();
        foreach ($src as $entity) {
            $urls[] = $entity->getUrl();
        }
        $urls = array_unique($urls);
        foreach($urls as $url)  {
            foreach ($this->scraper->scrape(new ScrapingDefinition($url, $this->definitions)) as $article) {
                $result[] = $article;
            }
        }
        return $result;
    }
}