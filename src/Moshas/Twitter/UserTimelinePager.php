<?php
/**
 * Date: 15/12/17
 * Time: 14:03.
 */

namespace Moshas\Twitter;


class UserTimelinePager extends StatusPager
{
    public function __construct(UserClient $client)
    {
        parent::__construct($client);
    }

    public function buildUrl()
    {
        return '/statuses/home_timeline.json';
    }

    public function buildQuery($maxId)
    {
        return array(
            'count' => 100,
            'max_id' => $maxId,
        );
    }
}