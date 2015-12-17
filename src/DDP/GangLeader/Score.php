<?php
namespace DDP\GangLeader;
use Moshas\Entity;
class Score extends Entity
{
    private $score = null;
    private $fighter = null;
    private $difficulty = null;
    private $stage = null;

    public function __construct (Entity $entity = null)
    {
        if ($entity) {
            if (preg_match('#ステージ(\S+).+?ファイター=(\S+).+?難易度=(\S+).+?Score=(\d+)#msu',  $entity->getBody(), $matches)) {
                $this->stage = $matches[1];
                $this->fighter = $matches[2];
                $this->difficulty = $matches[3];
                $this->score = $matches[4];
            } else {
                throw new \InvalidArgumentException('not score');
            }
            $this->setUrl($entity->getUrl());
            $this->setUserName($entity->getUserName());
            $this->setBody($entity->getBody());
            $this->setSubject($entity->getSubject());
            $this->setCreatedAt($entity->getCreatedAt());
            $this->setProfileImageUrl($entity->getProfileImageUrl());
        }
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
    }

    public function getDifficulty()
    {
        return $this->difficulty;
    }

    public function setFighter($fighter)
    {
        $this->fighter = $fighter;
    }

    public function getFighter()
    {
        return $this->fighter;
    }

    public function setStage($stage)
    {
        $this->stage = $stage;
    }

    public function getStage()
    {
        return $this->stage;
    }
}