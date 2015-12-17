<?php
namespace Moshas\Twitter;
use Moshas\MicroDateTime;

class ApplicationClient extends TwitterClient
{
    private $bearerToken = null;
    private $consumerKey = null;
    private $consumerSecret = null;

    const TOKEN_URL = 'https://api.twitter.com/oauth2/token';
    public function __construct ($consumerKey, $consumerSecret, $bearerToken = null)
    {
        if (!$consumerKey) {
            throw new \InvalidArgumentException('no consumer key');
        }
        if (!$consumerSecret) {
            throw new \InvalidArgumentException('no consumer secret');
        }
        $this->consumerKey    = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->bearerToken    = $bearerToken;
    }

    public function requestBearerToken()
    {
        return json_decode($this->sendOne(new \Loula\HttpRequest('POST', self::TOKEN_URL,
            array('grant_type' => 'client_credentials'),
            null,
            array('Authorization: Basic ' . base64_encode($this->consumerKey . ':' . $this->consumerSecret)))
        )->getBody());
    }

    public function getBearerToken()
    {
        return $this->bearerToken;
    }

    public function getConsumerKey()
    {
        return $this->consumerKey;
    }

    public function getConsumerSecret()
    {
        return $this->consumerSecret;
    }

    public function buildHeader($method, $url, array $query = null, MicroDateTime $dateTime = null)
    {
        if (!$this->bearerToken){
            $this->bearerToken = $this->requestBearerToken()->access_token;
        }
        return array('Authorization: Bearer ' . $this->bearerToken);
    }
}