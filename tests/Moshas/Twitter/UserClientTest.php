<?php
namespace Moshas\Twitter;
use Moshas\MicroDateTime;

class UserClientTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;
    private $dateTime = null;
    public function setUp()
    {
        $this->target = new \Moshas\Twitter\UserClient(
            'xvz1evFS4wEEPTGEFPHBog',
            'kAcSOqF21Fu85e7zjz7ZN2U4ZRhfV3WpwPAoE3Z7kBw',
            '370773112-GmHxMAgYyLbNEtIKZeRNFsMKPR9EyMZeS9weJAEb',
            'LswwdoUaIvS8ltyTt5jkRh4J50vUPVVHtR2YPi5kE'
        );
        $this->dateTime = new MicroDateTime();
        $this->dateTime->setTimestamp(1318622958);
        // not micro time. but this is using for oauth_nonce only.
        // this string is a test by twitter sample.
        $this->dateTime->setMicroTime('kYjzVBB8Y0ZFabxSWbWovY3uYSQ2pTgmZeNu2VS4cg');
    }

    public function testInstance()
    {
        $this->assertInstanceOf('\Moshas\Twitter\TwitterClient', $this->target);
    }


    public function testSignature()
    {
        $this->assertSame(
            array(
               'Authorization: OAuth include_entities=true,oauth_consumer_key=xvz1evFS4wEEPTGEFPHBog,oauth_nonce=kYjzVBB8Y0ZFabxSWbWovY3uYSQ2pTgmZeNu2VS4cg,oauth_signature_method=HMAC-SHA1,oauth_timestamp=1318622958,oauth_token=370773112-GmHxMAgYyLbNEtIKZeRNFsMKPR9EyMZeS9weJAEb,oauth_version=1.0,status=Hello+Ladies+%2B+Gentlemen%2C+a+signed+OAuth+request%21,oauth_signature=tnnArxj06cWHq44gCs1OSKk%2FjLY%3D',
            ),
            $this->target->buildHeader(
                'POST',
                'https://api.twitter.com/1/statuses/update.json',
                array(
                    'status' => 'Hello Ladies + Gentlemen, a signed OAuth request!',
                    'include_entities' => 'true',
                ),
                $this->dateTime
            ));
    }
}