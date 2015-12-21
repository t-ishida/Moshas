<?php
/**
 * Date: 15/11/25
 * Time: 18:54.
 */

namespace Inpas;


class PearsonTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $clazz = null;
    private $method = null;
    public function setUp()
    {
        $this->target = new Pearson(array(
            '山田さん' => array('ラーメン' => 2.5,'餃子' =>  3.5, 'チャーハン' =>  3.0, 'カレー' =>  3.5,'ザーサイ' => 2.5, 'メンマ' => 3.0),
            '田中さん' => array('ラーメン' => 3.0,'餃子' =>  3.5, 'チャーハン' =>  1.5, 'カレー' =>  5.0,'ザーサイ' => 3.0, 'メンマ' => 3.5),
            '佐藤さん' => array('ラーメン' => 2.5,'餃子' =>  3.0, 'チャーハン' =>  0, 'カレー' =>  3.5,'ザーサイ' => 0 , 'メンマ' => 4.0),
            '中村さん' => array('ラーメン' => 0,'餃子' =>  3.5, 'チャーハン' =>  3.0, 'カレー' =>  4.0,'ザーサイ' => 2.5, 'メンマ' => 4.5),
            '川村さん' => array('ラーメン' => 3.0,'餃子' =>  4.0, 'チャーハン' =>  2.0, 'カレー' =>  3.0,'ザーサイ' => 2.0, 'メンマ' => 3.0),
            '鈴木さん' => array('ラーメン' => 3.0,'餃子' =>  4.0, 'チャーハン' =>  0, 'カレー' =>  5.0,'ザーサイ' => 3.5, 'メンマ' => 3.0),
            '下林さん' => array('ラーメン' => 0,'餃子' =>   4.5, 'チャーハン' =>  0, 'カレー' =>  4.0,'ザーサイ' => 1.0, 'メンマ' => 0),
        ));
        $this->clazz = new \ReflectionClass($this->target);
        $this->method = $this->clazz->getMethod('score');
        $this->method->setAccessible(true);
    }

    public function testScore ()
    {
        $this->assertSame(1.0, $this->method->invokeArgs($this->target, array(
            array('ラーメン' => 3.0,'餃子' =>  3.5, 'チャーハン' =>  1.5, 'カレー' =>  5.0,'ザーサイ' => 3.0, 'メンマ' => 3.5),
            array('ラーメン' => 3.0,'餃子' =>  3.5, 'チャーハン' =>  1.5, 'カレー' =>  5.0,'ザーサイ' => 3.0, 'メンマ' => 3.5),
        )));
        $this->assertSame(0.32732683535399099, $this->method->invokeArgs($this->target, array(
            array('ラーメン' => 1.0,'餃子' =>  1.1, 'チャーハン' => 1.2, 'カレー' => 1.3, 'ザーサイ' => 1.4, 'メンマ' => 1.5),
            array('ラーメン' => 1.0,'餃子' =>  1.1, 'チャーハン' => 1.2, 'カレー' => 1.3, 'ザーサイ' => 1.4, 'メンマ' => 1.0),
        )));
    }
}
