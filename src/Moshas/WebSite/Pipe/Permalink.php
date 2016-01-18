<?php
namespace Moshas\WebSite\Pipe;
use Moshas\Pipe;
use Moshas\WebSite\Scraper;
use Moshas\WebSite\ScrapingDefinition;

class Permalink extends Pipe
{
    private $scraper = null;
    private $definitions = null;

    public function __construct(Scraper $scraper, array $definitions)
    {
        parent::__construct(null);
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
                $article->setUrl($url);
                $result[] = $article;
            }
        }
        return $result;
    }
}