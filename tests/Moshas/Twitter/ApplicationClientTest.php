<?php
namespace Moshas\Twitter;
use Moshas\MicroDateTime;

class ApplicationClientTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $target2 = null;
    public function setUp()
    {
        $this->target = \Phake::partialMock('\Moshas\Twitter\ApplicationClient','hoge','fuga');
        $this->target2 = new \Moshas\Twitter\ApplicationClient('hoge','fuga','piyo');
    }

    public function testInstance()
    {
        $this->assertInstanceOf('\Moshas\Twitter\TwitterClient', $this->target);
    }

    public function testBearerTokenWithRequest()
    {
        \Phake::when($this->target)->requestBearerToken()->thenReturn((object)array('access_token' => 'hoge'));
        $this->assertSame(array('Authorization: Bearer hoge'), $this->target->buildHeader('GET', 'URL', array('a' => 'b'), new MicroDateTime()));
    }

    public function testBearerTokenNoRequest()
    {
        $this->assertSame(array('Authorization: Bearer piyo'), $this->target2->buildHeader('GET', 'URL', array('a' => 'b'), new MicroDateTime()));
    }
}