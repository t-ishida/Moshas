<?php
/**
 * Date: 15/12/17
 * Time: 14:06.
 */

namespace Moshas\Twitter;


use Loula\HttpRequest;
use Moshas\MicroDateTime;

abstract class TwitterClient extends \Loula\HttpClient
{
    const BASE_URL  = 'https://api.twitter.com/1.1';
    public function get($url, $params = null)
    {
        return json_decode($this->sendOne(new HttpRequest('GET', self::BASE_URL . $url, $params, null, $this->buildHeader('GET', $url, $params, new MicroDateTime())))->getBody());
    }

    public function post($url, $params = null, $files = null)
    {
        return json_decode($this->sendOne(new HttpRequest('POST', self::BASE_URL . $url, $params, $files, $this->buildHeader('POST', $url, $params, new MicroDateTime())))->getBody());
    }

    public function put($url, $params = null, $files = null)
    {
        return json_decode($this->sendOne(new HttpRequest('PUT', self::BASE_URL . $url, $params, $files, $this->buildHeader('PUT', $url, $params, new MicroDateTime())))->getBody());
    }

    public function delete($url, $params = null)
    {
        return json_decode($this->sendOne(new HttpRequest('DELETE', self::BASE_URL . $url, $params, null, $this->buildHeader('DELETE', $url, $params, new MicroDateTime())))->getBody());
    }

    abstract public function buildHeader($method, $url, array $query = null, MicroDateTime $dateTime = null);
}