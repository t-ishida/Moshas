<?php
/**
 * Date: 15/12/17
 * Time: 16:44.
 */

namespace Moshas\Twitter;


class StatusPagerTest extends \PHPUnit_Framework_TestCase
{
    private $client = null;
    private $target = null;
    public function setUp()
    {
        $this->client = \Phake::mock('\Moshas\Twitter\TwitterClient');
        $this->target = \Phake::partialMock('\Moshas\Twitter\StatusPager', $this->client);
        \Phake::when($this->target)->buildUrl()->thenReturn('/url');
        \Phake::when($this->target)->buildQuery(null)->thenReturn(array('a' => 'b'));
        \Phake::when($this->target)->buildQuery('1234')->thenReturn(array('c' => 'd'));
        \Phake::when($this->client)->get('/url', array('a' => 'b'))->thenReturn((object)array(
            'statuses' => array(
                (object)array(
                    'text'  => 'hoge',
                    'created_at'  => '2015-01-01 12:34',
                    'id_str' => '1234',
                    'user' => (object) array(
                        'screen_name' => 't_ishida',
                        'profile_image_url_https' => 'https://url/path/img.jpg',
                    )
                )
            )
        ));
        \Phake::when($this->client)->get('/url', array('c' => 'd'))->thenReturn((object)array(
            'statuses' => array(),
        ));
    }

    public function testRun ()
    {
        $result = $this->target->run();
        $this->assertSame(1, count($result));
        $this->assertSame('hoge', $result[0]->getBody());
        $this->assertSame('hoge', $result[0]->getSubject());
        $this->assertSame('t_ishida', $result[0]->getUserName());
        $this->assertSame('https://url/path/img.jpg', $result[0]->getProfileImageUrl());
        $this->assertSame('2015-01-01 12:34', $result[0]->getCreatedAt());
        $this->assertSame('2015-01-01 12:34', $result[0]->getCreatedAt());
    }
}