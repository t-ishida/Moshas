<?php
namespace DDP\GangLeader;

use Moshas\Twitter\SearchWordPager;
use Moshas\Twitter\TwitterClient;

class ScoreSearchPager extends SearchWordPager
{
    public function __construct(TwitterClient $client, $difficulty = null, $stage = null)
    {
        $keyword = '怒首領蜂一面番長 Score ステージ ファイター 難易度';
        if ($stage)      $keyword .= ' ' . $stage;
        if ($difficulty) $keyword .= ' ' . $difficulty;
        parent::__construct($client, $keyword);
    }
}
