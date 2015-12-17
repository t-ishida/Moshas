<?php
namespace Moshas\Twitter;
class SearchWordPager extends StatusPager
{
    private $keyword = null;
    public function __construct(TwitterClient $client, $keyword)
    {
        parent::__construct($client);
        $this->keyword = $keyword;
    }

    public function buildQuery($maxId)
    {
         return array(
            'q' => $this->keyword,
            'max_id' => $maxId,
            'count' => 100,
        );
    }

    public function buildUrl()
    {
        return '/search/tweets.json';
    }
}