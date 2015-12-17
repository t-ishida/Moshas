<?php
$configPath = __DIR__ . '/../.twitter';
if (!is_file($configPath)) {?>
plz create a config file to <?php print $configPath ?> like this.

<?php print "<?php \n"; ?>
return (object)array (
    'consumerKey' => 'your twitter consumer key',
    'consumerSecret' => 'your twitter consumer secret',
    'bearer' => 'your bearer',
);
<?php
}
require __DIR__ . '/../vendor/autoload.php';
$config = require $configPath;
try {

    $client = new \Moshas\Twitter\ApplicationClient(
            $config->consumerKey,
            $config->consumerSecret,
            isset($config->bearer) ? $config->bearer : null
    );
    $config->bearer = $client->getBearerToken();
    file_put_contents($configPath, '<?php return (object)' . var_export((array)$config, true) . ';');
    $result = (new \Moshas\Crawler(
        array(new \DDP\GangLeader\ScoreSearchPager($client)),
        array(new \DDP\GangLeader\ScoreConverter()),
        array(new \DDP\GangLeader\ScoreSorter()))
    )->execute();
    $i = 1;
    foreach ($result as $row) {
        print $i++ . ':' . $row->getUserName() . ' ' . $row->getStage() . '@' . $row->getDifficulty() . ' => '. $row->getScore()  . "\n";
    }
} catch (\Exception $e) {
    var_dump($e);
}

