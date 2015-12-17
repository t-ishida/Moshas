<?php
/**
 * Date: 15/12/17
 * Time: 17:23.
 */

namespace DDP\GangLeader;


use Moshas\Entity;

class ScoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorEmptyString()
    {
        new Score(new Entity());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorInvalidString()
    {
        $entity = new Entity();
        $entity->setBody('hoge');
        new Score($entity);
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
        $score = new Score($entity);
        $this->assertInstanceOf('\DDP\GangLeader\Score', $score);
        $this->assertSame('１～２（全２面）', $score->getStage());
        $this->assertSame('特攻隊長(Hard)', $score->getDifficulty());
        $this->assertSame('4918110', $score->getScore());
        $this->assertSame('t_ishida', $score->getUserName());
        $this->assertSame('https://pbs.twimg.com/profile_images/55875903/randomkitten_bigger.jpeg', $score->getProfileImageUrl());
        $this->assertSame('https://twitter.com/t_ishida/status/677131650585640960', $score->getUrl());
        $this->assertSame('怒首領蜂一面番長
ステージ１～２（全２面）
ファイター=Type-A(朱里)
難易度=特攻隊長(Hard)
Score=4918110点
 https://t.co/Ojz2Hse28r https://t.co/btKIBBa5HT', $score->getBody());
        $this->assertSame('怒首領蜂一面番長
ステージ１～２（全２面）
ファイター=Type-A(朱里)
難易度=特攻隊長(Hard)
Score=4918110点
 https://t.co/Ojz2Hse28r https://t.co/btKIBBa5HT', $score->getSubject());
    }
}