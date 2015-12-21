<?php
namespace Inpas;
class LinearRegressionTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    public function setUp() {
        $this->target = new LinearRegression(array(
            new Rectanglar(1, 1.3),
            new Rectanglar(2, 1.8),
            new Rectanglar(3, 3.2),
            new Rectanglar(4, 4.7),
            new Rectanglar(5, 5.8),
            new Rectanglar(6, 6.9),
            new Rectanglar(7, 7.2),
            new Rectanglar(8, 7.5),
            new Rectanglar(9, 8.6),
            new Rectanglar(10, 10.5),
        ));
    }


    public function testCalc()
    {
        $this->assertEquals('y = 0.97272727272727x + 0.4', $this->target->__toString());
        $this->assertEquals(1.3, floor($this->target->calc(1) * 10) / 10);
    }
}
