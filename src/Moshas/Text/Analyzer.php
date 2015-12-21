<?php
/**
 * Date: 15/12/21
 * Time: 11:16.
 */

namespace Moshas\Text;


use Moshas\Text\Parse\Strategy;
use Moshas\Worker;

class Analyzer implements Worker
{
    private $strategy  = null;
    public function __construct (Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function work($entity)
    {
        return new Entity($entity, $this->strategy->analyze($entity->getBody()));
    }
}