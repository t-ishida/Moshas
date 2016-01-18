<?php
namespace Moshas;

class PipeTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $entity  = null;
    private $entity2 = null;
    private $entity3 = null;
    private $lastTarget = null;
    private $next = null;

    public function setUp()
    {
        $this->next = \Phake::mock('\Moshas\Pipe');
        $this->entity  = new Entity();
        $this->entity2 = new Entity();
        $this->entity3 = new Entity();
        $this->target = \Phake::partialMock('\Moshas\Pipe', $this->next);
        $this->lastTarget = \Phake::partialMock('\Moshas\Pipe');
    }

    public function testRun ()
    {
        \Phake::when($this->lastTarget)->runWith(null)->thenReturn(array($this->entity));
        $this->assertSame(array($this->entity), $this->lastTarget->run());
    }

    public function testRunWithNoNext ()
    {
        \Phake::when($this->lastTarget)->work(array($this->entity))->thenReturn(array($this->entity));
        $this->assertSame(array($this->entity), $this->lastTarget->runWith(array($this->entity)));
    }

    public function testRunWith()
    {
        \Phake::when($this->target)->work(array($this->entity))->thenReturn(array($this->entity, $this->entity2));
        \Phake::when($this->next)->runWith(array($this->entity, $this->entity2))->thenReturn(array($this->entity, $this->entity2, $this->entity3));
        $this->assertSame(array($this->entity,$this->entity2, $this->entity3), $this->target->runWith(array($this->entity)));
    }
}