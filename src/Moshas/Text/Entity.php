<?php
namespace Moshas\Text;

class Entity extends \Moshas\Entity
{
    private $words = null;
    private $original = null;
    public function __construct (\Moshas\Entity $entity, array $words)
    {
        $this->setSubject($entity->getSubject());
        $this->setBody($entity->getBody());
        $this->setUrl($entity->getUrl());
        $this->setProfileImageUrl($entity->getProfileImageUrl());
        $this->setUserName($entity->getUserName());
        $this->words = $words;
        $this->original = $entity;
    }

    public function getOriginal()
    {
        return $this->original;
    }

    public function getWords()
    {
        return $this->words;
    }
}