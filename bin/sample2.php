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
    die;
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
    die;
}
ini_set('memory_limit', '2048M');
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
        array(new \Moshas\Twitter\SearchWordPager($client, '#ゴ魔乙 OR ゴシックは魔法乙女 OR ゴ魔乙 OR #ゴシックは魔法乙女')),
        array(new \Moshas\Text\Analyzer(new \Moshas\Text\Parse\Yahoo($yahooConfig->appId, $yahooConfig->appSecret)))
    );

    $words = array();
    $users = array();
    $tweets = $crawler->execute();
    foreach ($tweets as $tweet) {
        $users[$tweet->getUserName()] = 1;
        foreach ($tweet->getWords() as $word) {
            if ($word->getPart() !== '名詞') continue;
            if (!isset($words[$word->getSurface()])) {
                $words[$word->getSurface()] = 0;
            }
            $words[$word->getSurface()]++;
        }
    }
    $i = 0;
    $wordKeys = array_keys($words);
    $wordDictionary = array();
    foreach ($wordKeys as $key) {
        $wordDictionary[$key] = $i++;
    }
    $i = 0;
    $userKeys = array_keys($users);
    $userDictionary = array();
    foreach ($userKeys as $key) {
        $userDictionary[$key] = $i++;
    }
    unset($words);
    unset($users);
    $data = array();
    $rowNames = array();
    echo "<<TWEET>>\n";
    foreach ($tweets as $tweet) {
        $row = null;
        if (isset($data[$userDictionary[$tweet->getUserName()]])) {
            $row = $data[$userDictionary[$tweet->getUserName()]];
        } else {
            $row = array();
            foreach($wordKeys as $key) {
                $row[] = 0;
            }
        }
        foreach ($tweet->getWords() as $word) {
            if ($word->getPart() !== '名詞') continue;
            $row[$wordDictionary[$word->getSurface()]]++;
        }
        $data[$userDictionary[$tweet->getUserName()]] = $row;
    }
    print new \Inpas\Clustering(new \Inpas\Matrix($data, $wordKeys, $userKeys));
} catch (\Exception $e) {
    var_dump($e);
}
