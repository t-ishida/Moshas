<?php
$yahooPath = __DIR__ . '/../.yahoo';
if (!is_file($yahooPath)) {?>
plz create a config file to <?php print $yahooPath ?> like this.

<?php print "<?php \n"; ?>
return (object)array(
    'appId' => 'your appId',
    'appSecret' => 'your appSecret',
);
<?php
}

$twitterPath = __DIR__ . '/../.twitter';
if (!is_file($twitterPath)) {?>
plz create a config file to <?php print $twitterPath ?> like this.

<?php print "<?php \n"; ?>
return (object)array (
    'consumerKey' => 'your twitter consumer key',
    'consumerSecret' => 'your twitter consumer secret',
    'bearer' => 'your bearer',
);
<?php
}
require __DIR__ . '/../vendor/autoload.php';
$yahooConfig   = require $yahooPath;
$twitterConfig = require $twitterPath;
try {
    $client = new \Moshas\Twitter\ApplicationClient(
        $twitterConfig->consumerKey,
        $twitterConfig->consumerSecret,
        isset($twitterConfig->bearer) ? $twitterConfig->bearer : null
    );
    $twitterConfig->bearer = $client->getBearerToken();
    file_put_contents($twitterPath, "<?php return (object)" . var_export((array)$twitterConfig, true) . ';');
    $crawler = new \Moshas\Crawler(
        array(new \Moshas\Twitter\SearchWordPager($client, 'ロザリーはまな板乙女')),
        array(new \Moshas\Text\Analyzer(new \Moshas\Text\Parse\Yahoo($yahooConfig->appId, $yahooConfig->appSecret)))
    );

    echo "<<TWEET>>\n";
    $result = array();
    foreach ($crawler->execute() as $tweet) {
        echo $tweet->getBody() . "\n";
        foreach ($tweet->getWords() as $word) {
            if (!isset($result[$word->getPart()])) {
                $result[$word->getPart()] = array();
            }
            if (!isset($result[$word->getPart()][$word->getSurface()])) {
                $result[$word->getPart()][$word->getSurface()] = 0;
            }
            $result[$word->getPart()][$word->getSurface()]++;
        }
    }
    arsort($result['名詞']);
    echo "<<WORD>>\n";
    $i = 1;
    foreach($result['名詞'] as $key => $val) {
        echo $i++ . ": $key => $val\n";
    }
} catch (\Exception $e) {
    var_dump($e);
}
