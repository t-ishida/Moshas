<?php
/**
 * Date: 15/12/28
 * Time: 14:20.
 */

namespace Moshas;


class DummyClient implements Client
{
    private $entities = null;
    public function __construct (array $entities)
    {
        $this->entities = $entities;
    }

    public function run()
    {
        return $this->entities;
    }
}