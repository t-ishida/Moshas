<?php
namespace Moshas\Text;

class Entity extends \Moshas\Entity
{
    private $words = null;
    private $original = null;
    private $category = null;

    public function __construct (\Moshas\Entity $entity, array $words, $category = null)
    {
        $this->setSubject($entity->getSubject());
        $this->setBody($entity->getBody());
        $this->setUrl($entity->getUrl());
        $this->setProfileImageUrl($entity->getProfileImageUrl());
        $this->setUserName($entity->getUserName());
        $this->words = $words;
        $this->original = $entity;
        $this->category = $category;
    }

    public function getOriginal()
    {
        return $this->original;
    }

    public function getWords()
    {
        return $this->words;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }
}