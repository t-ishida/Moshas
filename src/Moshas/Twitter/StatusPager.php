<?php
namespace Moshas\Twitter;
use Moshas\Client;
use Moshas\Entity;
abstract class StatusPager implements Client
{
    private $client = null;

    public function __construct (TwitterClient $client)
    {
        $this->client = $client;
    }

    public function run()
    {
        $maxId = null;
        $result = array();
        $limit = $this->getLimit();
        while (true) {
            $page = $this->client->get($this->buildUrl(), $this->buildQuery($maxId));
            if (!$page->statuses || count($result) >= $limit) break;
            foreach ($page->statuses as $row) {
                $entity = new Entity();
                $entity->setBody($row->text);
                $entity->setSubject($row->text);
                $entity->setCreatedAt($row->created_at);
                $entity->setUserName($row->user->screen_name);
                $entity->setProfileImageUrl($row->user->profile_image_url_https);
                $result[] = $entity;
                $maxId = intval($row->id_str) - 1;
            }
        }
        return $result;
    }

    abstract public function buildUrl();
    abstract public function buildQuery($maxId);
    public function getLimit()
    {
        return 1000;
    }
}
