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
        foreach ($src as $entity) {
            foreach ($this->scraper->scrape(new ScrapingDefinition($entity->getUrl(), $this->definitions)) as $article) {
                $article->setUrl($entity->getUrl());
                $result[] = $article;
            }
        }
        return $result;
    }
}