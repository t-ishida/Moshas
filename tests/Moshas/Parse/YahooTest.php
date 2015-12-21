<?php
/**
 * Date: 15/12/21
 * Time: 18:53.
 */

namespace Moshas\Parse;


use Loula\HttpRequest;
use Loula\HttpResponse;
use Moshas\Text\Parse\Yahoo;

class YahooTest extends \PHPUnit_Framework_TestCase
{
    private $target = null;

    protected function setUp()
    {
        $this->target = \Phake::partialMock('\Moshas\Text\Parse\Yahoo', 'hoge', 'fuga');
    }

    public function testAnalyze()
    {
        $obj = new HttpResponse("ヘッダ\r\n\r\n" . '<?xml version="1.0" encoding="UTF-8" ?>
<ResultSet xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:yahoo:jp:jlp" xsi:schemaLocation="urn:yahoo:jp:jlp http://jlp.yahooapis.jp/MAService/V1/parseResponse.xsd">
  <ma_result>
    <total_count>9</total_count>
    <filtered_count>9</filtered_count>
    <word_list>
      <word>
      <surface>庭</surface>
      <reading>にわ</reading>
      <pos>名詞</pos>
      <baseform>庭</baseform>
      </word>
      <word>
      <surface>に</surface>
      <reading>に</reading>
      <pos>助詞</pos>
      <baseform>に</baseform>
      </word>
      <word>
      <surface>は</surface>
      <reading>は</reading>
      <pos>助詞</pos>
      <baseform>は</baseform>
      </word>
      <word>
      <surface>二</surface>
      <reading>2</reading>
      <pos>名詞</pos>
      <baseform>2</baseform>
      </word>
      <word>
      <surface>羽</surface>
      <reading>わ</reading>
      <pos>名詞</pos>
      <baseform>羽</baseform>
      </word>
      <word>
      <surface>ニワトリ</surface>
      <reading>にわとり</reading>
      <pos>名詞</pos>
      <baseform>ニワトリ</baseform>
      </word>
      <word>
      <surface>が</surface>
      <reading>が</reading>
      <pos>助詞</pos>
      <baseform>が</baseform>
      </word>
      <word>
      <surface>いる</surface>
      <reading>いる</reading>
      <pos>動詞</pos>
      <baseform>いる</baseform>
      </word>
      <word>
      <surface>。</surface>
      <reading>。</reading>
      <pos>特殊</pos>
      <baseform>。</baseform>
      </word>
    </word_list>
  </ma_result>
</ResultSet>', array('http_code' => 200));
        \Phake::when($this->target)->sendOne(new HttpRequest('GET', Yahoo::BASE_URL, array(
            'appid'  => 'hoge',
            'sentence' => '庭には二羽ニワトリがいる。',
            'results' => 'ma',
        )))->thenReturn($obj);
        $result = $this->target->analyze('庭には二羽ニワトリがいる。');
        $this->assertSame(9, count($result));
        $this->assertSame('庭', $result[0]->getSurface());
        $this->assertSame('にわ', $result[0]->getReading());
        $this->assertSame('名詞', $result[0]->getPart());
        $this->assertSame('に', $result[1]->getSurface());
        $this->assertSame('は', $result[2]->getSurface());
        $this->assertSame('二', $result[3]->getSurface());
        $this->assertSame('羽', $result[4]->getSurface());
        $this->assertSame('ニワトリ', $result[5]->getSurface());
        $this->assertSame('が', $result[6]->getSurface());
        $this->assertSame('いる', $result[7]->getSurface());
        $this->assertSame('。', $result[8]->getSurface());
    }
}