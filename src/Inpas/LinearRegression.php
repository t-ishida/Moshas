<?php
/**
 * Date: 15/12/10
 * Time: 14:52.
 */

namespace Inpas;


class LinearRegression
{
    private $slope = null;
    private $intercept = null;
    private $tValue = null;
    private $pValue = null;

    /**
     * @var Rectanglar[]
     */
    private $list = null;

    public function __construct(array $list)
    {
        $xySum = 0;
        $xSum = 0;
        $ySum = 0;
        $xSquareSum = 0;
        $count = count($list);
        foreach ($list as $obj) {
            $xSum += $obj->getX();
            $ySum += $obj->getY();
            $xySum += $obj->getX() * $obj->getY();
            $xSquareSum += pow($obj->getX(), 2);
        }
        $a = ($xySum - ($xSum * $ySum) / $count) / ($xSquareSum - ($xSum * $xSum) / $count);
        $b = ($ySum - $a * $xSum) / $count;
        $this->slope = $a;
        $this->intercept = $b;
        $this->list = $list;
        $this->tValue = $this->slope * ($count - 2) ^ 0.5 / (1 - $this->slope ^ 2) ^ 0.5;
        /*
        $halfA = array();
        $halfB = $list;
        while (count($halfB) > $count / 2) {
            shuffle($halfB);
            $halfA[] = array_shift($halfB);
        }
        */
    }

    public function calc ($x)
    {
        return ($x * $this->slope) + $this->intercept;
    }

    /**
     * @return null
     */
    public function getSlope()
    {
        return $this->slope;
    }

    /**
     * @return null
     */
    public function getIntercept()
    {
        return $this->intercept;
    }

    /**
     * @return null
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @return null
     */
    public function getPValue()
    {
        return $this->pValue;
    }

    /**
     * @return null
     */
    public function getTValue()
    {
        return $this->tValue;
    }


    public function __toString()
    {
        $result =  "y = " . $this->getSlope() . "x + " . $this->getIntercept();
        return $result;
    }
}