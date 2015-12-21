<?php
namespace Moshas\Text;

class Word 
{
    private $surface = null;
    private $reading = null;
    private $part = null;

    public function setPart($part)
    {
        $this->part = $part;
    }

    public function getPart()
    {
        return $this->part;
    }

    public function setReading($reading)
    {
        $this->reading = $reading;
    }

    public function getReading()
    {
        return $this->reading;
    }

    public function setSurface($surface)
    {
        $this->surface = $surface;
    }

    public function getSurface()
    {
        return $this->surface;
    }
}