<?php
namespace Moshas;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $client = null;
    private $worker = null;
    private $reducer = null;
    private $workerResult = null;
    private $reducerResult = null;
    private $clientResult = null;

    public function setUp()
    {
        $this->worker = \Phake::mock('\Moshas\Worker');
        $this->reducer = \Phake::mock('\Moshas\Reducer');
        $this->client = \Phake::mock('\Moshas\Client');
        $this->workerResult = new Entity();
        $this->reducerResult = new Entity();
        $this->clientResult = new Entity();
        $this->workerResult->setBody('worker');
        $this->reducerResult->setBody('reducer');
        $this->clientResult->setBody('client');
        \Phake::when($this->client)->run()->thenReturn(array($this->clientResult));
    }

    public function testClientOnly()
    {
        $this->target = new Crawler(array($this->client));
        $result = $this->target->execute();
        $this->assertSame(array($this->clientResult), $result);
    }

    public function testExecuteNoReducer()
    {
        $this->target = new Crawler(array($this->client), array($this->worker));
        \Phake::when($this->worker)->work($this->clientResult)->thenReturn($this->workerResult);
        $result = $this->target->execute();
        $this->assertSame(array($this->workerResult), $result);
    }

    public function testExecuteNoWorker()
    {
        $this->target = new Crawler(array($this->client), null, array($this->reducer));
        \Phake::when($this->reducer)->reduce(array($this->clientResult))->thenReturn(array($this->reducerResult));
        $result = $this->target->execute();
        $this->assertSame(array($this->reducerResult), $result);
    }
}