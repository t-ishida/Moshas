<?php
namespace DDP\GangLeader;
use Moshas\Reducer;
class ScoreSorter implements Reducer
{
    public function reduce(array $entities)
    {
        usort($entities, function($a, $b){return $a->getScore() < $b->getScore() ? 1 : -1;});
        return $entities;
    }
}