<?php
namespace Moshas\WebSite\Pipe;
use Moshas\Entity;

class StartTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $scraper = null;
    private $definition = null;
    private $next = null;
    public function setUp()
    {
        $this->scraper = \Phake::mock('Moshas\WebSite\Scraper');
        $this->definition = \Phake::mock('Moshas\WebSite\ScrapingDefinition');
        $this->next = \Phake::mock('Moshas\Pipe');
        $this->target = new Start($this->scraper, $this->definition, $this->next);
    }

    public function testWork()
    {
        \Phake::when($this->scraper)->scrape(\Phake::anyParameters())->thenReturn(array(
            new Entity(),
            new Entity(),
        ));
        $result = $this->target->work(null);
        \Phake::verify($this->scraper)->scrape($this->definition);
        $this->assertCount(2, $result);
    }
}