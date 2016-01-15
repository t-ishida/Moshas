<?php
namespace Moshas;


abstract class Pipe implements Client
{
    private $next = null;
    public function __construct($next = null)
    {
        $this->next = $next;
    }

    public function run ()
    {
        return $this->runWith(null);
    }

    public function runWith ($src)
    {
        $result = $this->work($src);
        return $this->next ? $this->next->runWith($result) : $result;
    }

    abstract public function work ($src);
}