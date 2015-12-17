<?php
/**
 * Date: 15/12/17
 * Time: 14:08.
 */

namespace Moshas\Twitter;


use Moshas\MicroDateTime;

class UserClient extends TwitterClient
{
    private $consumerKey = null;
    private $consumerSecret = null;
    private $accessToken = null;
    private $accessTokenSecret = null;

    public function __construct ($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->accessToken = $accessToken;
        $this->accessTokenSecret = $accessTokenSecret;
    }

    public function buildHeader($method, $url, array $query = null, MicroDateTime $dateTime = null)
    {
        $a = $query;
        $b = array(
            'oauth_token' => $this->accessToken ,
            'oauth_consumer_key' => $this->consumerKey ,
            'oauth_signature_method' => 'HMAC-SHA1' ,
            'oauth_timestamp' => $dateTime->getTimestamp(),
            'oauth_nonce' =>  $dateTime->getMicroTime(),
            'oauth_version' => '1.0' ,
        );
        $c = array_merge($a, $b);
        ksort($c);
        $signatureKey  = rawurldecode($this->consumerSecret) . '&' . rawurldecode($this->accessTokenSecret);
        $signatureData = rawurlencode($method) . '&' .
            rawurlencode($url) . '&' .
            rawurlencode(str_replace(array('+', '%7E'), array('%20', '~') ,http_build_query($c, '', '&')));
        $c['oauth_signature'] = base64_encode(hash_hmac('sha1', $signatureData, $signatureKey, true));
        return array('Authorization: OAuth ' . http_build_query($c, '', ','));
    }
}