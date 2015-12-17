<?php
namespace DDP\GangLeader;
use Moshas\Worker;

class ScoreConverter implements Worker
{
    public function work($entity)
    {
        try {
            return new Score($entity);
        }catch (\Exception $e){}
    }
}