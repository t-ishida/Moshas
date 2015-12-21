<?php
/**
 * Date: 15/12/10
 * Time: 15:41.
 */

namespace Inpas;


class Rectanglar
{
    private $x = null;
    private $y = null;
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return null
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return null
     */
    public function getY()
    {
        return $this->y;
    }

}