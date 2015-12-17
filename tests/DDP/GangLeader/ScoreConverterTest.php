<?php
/**
 * Date: 15/12/17
 * Time: 10:40.
 */

namespace DDP\GangLeader;


use Moshas\Entity;

class ScoreConverterTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    public function setUp()
    {
        $this->target = new ScoreConverter();
    }

    public function testEmptyString()
    {
        $this->assertEmpty($this->target->work(new Entity()));
    }

    public function testInvalidString()
    {
        $entity = new Entity();
        $entity->setBody('hoge');
        $this->assertEmpty($this->target->work($entity));
    }

    public function testScoreEntity()
    {
        $entity = new Entity();
        $entity->setProfileImageUrl('https://pbs.twimg.com/profile_images/55875903/randomkitten_bigger.jpeg');
        $entity->setUserName('t_ishida');
        $entity->setUrl('https://twitter.com/t_ishida/status/677131650585640960');
        $entity->setBody('怒首領蜂一面番長
ステージ１～２（全２面）
ファイター=Type-A(朱里)
難易度=特攻隊長(Hard)
Score=4918110点
 https://t.co/Ojz2Hse28r https://t.co/btKIBBa5HT');
        $entity->setSubject($entity->getBody());
        $score = $this->target->work($entity);
        $this->assertInstanceOf('\DDP\GangLeader\Score', $score);
    }
}