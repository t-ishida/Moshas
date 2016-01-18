<?php
namespace Moshas\WebSite\Pipe;


use Moshas\Entity;

class LinkToNextTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $entity1 = null;
    private $entity2 = null;
    private $scraper = null;
    private $definitions = null;
    private $next = null;
    public function setUp()
    {
        $this->scraper = \Phake::mock('Moshas\WebSite\Scraper');
        $this->definitions = array(\Phake::mock('Moshas\WebSite\FieldDefinition'));
        $this->next = \Phake::mock('Moshas\Pipe');
        $this->entity1 = new Entity();
        $this->entity2 = new Entity();
        $this->entity1->setUrl('url');
        $this->entity2->setUrl('url');
        $this->target = new LinkToNext($this->scraper, $this->definitions, $this->next);
    }

    public function testWork()
    {
        \Phake::when($this->scraper)->scrape(\Phake::anyParameters())->thenReturn(array(
            new Entity(),
            new Entity(),
        ));
        $result = $this->target->work(array(
            $this->entity1,
            $this->entity2,
        ));
        $this->assertCount(2, $result);
    }
}