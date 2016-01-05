<?php
namespace Moshas;
class Entity
{
    private $userName = null;
    private $profileImageUrl = null;
    private $subject = null;
    private $body = null;
    private $url = null;
    private $createdAt = null;

    public function __construct($userName = null, $profileImageUrl = null, $subject = null, $body = null, $url = null, $createdAt = null)
    {
        $this->userName = $userName;
        $this->url = $url;
        $this->subject = $subject;
        $this->profileImageUrl = $profileImageUrl;
        $this->createdAt = $createdAt;
        $this->body = $body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setProfileImageUrl($profileImageUrl)
    {
        $this->profileImageUrl = $profileImageUrl;
    }

    public function getProfileImageUrl()
    {
        return $this->profileImageUrl;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }
}