<?php
/**
 * Date: 15/12/21
 * Time: 11:19.
 */

namespace Moshas\Text\Parse;


use Loula\HttpClient;
use Loula\HttpRequest;
use Moshas\Text\Word;

class Yahoo extends HttpClient implements Strategy
{
    private $appId     = null;
    private $appSecret = null;
    const BASE_URL = 'http://jlp.yahooapis.jp/MAService/V1/parse';
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function analyze ($sentence)
    {
        $response = $this->sendOne(new HttpRequest('GET', self::BASE_URL, array(
            'appid' => $this->appId,
            'sentence' => $sentence,
            'results' => 'ma',
        )));
        $xml = new \SimpleXMLElement($response->getBody());
        $result = null;
        foreach ($xml->ma_result->word_list->word as $word) {
            $wordEntity = new Word();
            $wordEntity->setReading((string)$word->reading);
            $wordEntity->setSurface((string)$word->surface);
            $wordEntity->setPart((string)$word->pos);
            $result[] = $wordEntity;
        }
        return $result;
    }
}