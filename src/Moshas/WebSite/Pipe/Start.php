<?php
namespace Moshas\WebSite\Pipe;


use Moshas\Pipe;
use Moshas\WebSite\Scraper;

class Start extends Pipe
{
    private $scraper = null;
    private $definition = null;
    public function __construct(Scraper $scraper, $definition, $next)
    {
        parent::__construct($next);
        $this->scraper = $scraper;
        $this->definition = $definition;
    }

    public function work($src)
    {
        return $this->scraper->scrape($this->definition);
    }
}