<?php
/**
 * see http://gihyo.jp/dev/serial/01/machine-learning/0003
 */
use Moshas\Text\NaiveBayes;

$yahooPath = __DIR__ . '/../.yahoo';
if (!is_file($yahooPath)) {?>
    plz create a config file to <?php print $yahooPath ?> like this.

    <?php print "<?php \n"; ?>
    return (object)array(
    'appId' => 'your appId',
    'appSecret' => 'your appSecret',
    );
<?php
    die;
}

require __DIR__ . '/../vendor/autoload.php';
$yahooConfig   = require $yahooPath;
try {
    $parser = new \Moshas\Text\Parse\Yahoo($yahooConfig->appId, $yahooConfig->appSecret);
    $crawler = new \Moshas\Crawler(
        array(new \Moshas\DummyClient(array(
            new \Moshas\Entity('hoge','fuga', 'オランダ人が作った',  'オランダ人が作った'),
            new \Moshas\Entity('hoge','fuga', '豊富なドキュメントや豊富なライブラリがあります.',  '豊富なドキュメントや豊富なライブラリがあります.'),
            new \Moshas\Entity('hoge','fuga', '純粋なオブジェクト指向言語です.',  '純粋なオブジェクト指向言語です.'),
            new \Moshas\Entity('hoge','fuga', 'Rubyはまつもとゆきひろ氏(通称Matz)により開発されました.',  'Rubyはまつもとゆきひろ氏(通称Matz)により開発されました.'),
            new \Moshas\Entity('hoge','fuga', '「機械学習 はじめよう」が始まりました.',  '「機械学習 はじめよう」が始まりました.'),
            new \Moshas\Entity('hoge','fuga', '検索エンジンや画像認識に利用されています.',  '検索エンジンや画像認識に利用されています.'),
        ))),
        array(
            new \Moshas\Text\Analyzer($parser),
            new NaiveBayes($parser, array(
                (object)array(
                   'document'  => 'Python（パイソン）は，オランダ人のグイド・ヴァンロッサムが作ったオープンソースのプログラミング言語。
オブジェクト指向スクリプト言語の一種であり，Perlとともに欧米で広く普及している。イギリスのテレビ局 BBC が製作したコメディ番組『空飛ぶモンティパイソン』にちなんで名付けられた。
Python は英語で爬虫類のニシキヘビの意味で，Python言語のマスコットやアイコンとして使われることがある。Pythonは汎用の高水準言語である。プログラマの生産性とコードの信頼性を重視して設計されており，核となるシンタックスおよびセマンティクスは必要最小限に抑えられている反面，利便性の高い大規模な標準ライブラリを備えている。
Unicode による文字列操作をサポートしており，日本語処理も標準で可能である。多くのプラットフォームをサポートしており（動作するプラットフォーム），また，豊富なドキュメント，豊富なライブラリがあることから，産業界でも利用が増えつつある。',
                    'category' => 'Python',
                ),
                (object) array(
                    'document' => 'Ruby（ルビー）は，まつもとゆきひろ（通称Matz）により開発されたオブジェクト指向スクリプト言語であり，
従来 Perlなどのスクリプト言語が用いられてきた領域でのオブジェクト指向プログラミングを実現する。
Rubyは当初1993年2月24日に生まれ， 1995年12月にfj上で発表された。
名称のRubyは，プログラミング言語Perlが6月の誕生石であるPearl（真珠）と同じ発音をすることから，まつもとの同僚の誕生石（7月）のルビーを取って名付けられた。',
                    'category' => 'Ruby',
                ),
                (object)array(
                    'document' => '豊富な機械学習（きかいがくしゅう，Machine learning）とは，人工知能における研究課題の一つで，
人間が自然に行っている学習能力と同様の機能をコンピュータで実現させるための技術・手法のことである。ある程度の数のサンプルデータ集合を対象に解析を行い，
そのデータから有用な規則，ルール，知識表現，判断基準などを抽出する。データ集合を解析するため，統計学との関連も非常に深い。
機械学習は検索エンジン，医療診断，スパムメールの検出，金融市場の予測，DNA配列の分類，音声認識や文字認識などのパターン認識，ゲーム戦略，ロボット，など幅広い分野で用いられている。
応用分野の特性に応じて学習手法も適切に選択する必要があり，様々な手法が提案されている。
それらの手法は， Machine Learning や IEEE Transactions on Pattern Analysis and Machine Intelligence などの学術雑誌などで発表されることが多い。',
                    'category' => '機械学習',
        )))));
    foreach ($crawler->execute() as $entity)  {
        print $entity->getBody() . " 推定カテゴリ: " . $entity->getCategory() . "\n";
    }
} catch (\Exception $e) {
    var_dump($e);
}




