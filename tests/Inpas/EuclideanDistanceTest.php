<?php
/**
 * Date: 15/11/25
 * Time: 18:54.
 */

namespace Inpas;
class EuclideanDistanceTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $clazz = null;
    private $method = null;
    public function setUp()
    {
        $this->target = new EuclideanDistance(array(
            'userA' => array('ラーメン' => 1,'餃子' =>  1, 'チャーハン' =>  1, 'カレー' =>  0,'ザーサイ' => 0, 'メンマ' =>1),
            'userB' => array('ラーメン' => 1,'餃子' =>  0, 'チャーハン' =>  1, 'カレー' =>  0,'ザーサイ' => 0, 'メンマ' =>0),
            'userC' => array('ラーメン' => 1,'餃子' =>  1, 'チャーハン' =>  0, 'カレー' =>  0,'ザーサイ' => 0, 'メンマ' =>1),
            'userD' => array('ラーメン' => 0,'餃子' =>  0, 'チャーハン' =>  0, 'カレー' =>  1,'ザーサイ' => 0, 'メンマ' =>1),
            'userE' => array('ラーメン' => 0,'餃子' =>  0, 'チャーハン' =>  0, 'カレー' =>  0,'ザーサイ' => 1, 'メンマ' =>0),
        ));
        $this->clazz = new \ReflectionClass($this->target);
        $this->method = $this->clazz->getMethod('score');
        $this->method->setAccessible(true);
    }

    public function testScore ()
    {
        $this->assertSame(0.5, $this->method->invokeArgs($this->target, array(
            array('ラーメン' => 1,'餃子' =>  1, 'チャーハン' =>  1, 'カレー' =>  0,'ザーサイ' => 0, 'メンマ' =>1),
            array('ラーメン' => 1,'餃子' =>  1, 'チャーハン' =>  1, 'カレー' =>  0,'ザーサイ' => 0, 'メンマ' =>0),
        )));
        $this->assertSame(1.0, $this->method->invokeArgs($this->target, array(
            array('ラーメン' => 1,'餃子' =>  1, 'チャーハン' =>  1, 'カレー' =>  0,'ザーサイ' => 0, 'メンマ' =>1),
            array('ラーメン' => 1,'餃子' =>  1, 'チャーハン' =>  1, 'カレー' =>  0,'ザーサイ' => 0, 'メンマ' =>1),
        )));
    }
}
