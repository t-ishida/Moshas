<?php
use Moshas\Crawler;
use Moshas\WebSite\Definition\BodyDefinition;
use Moshas\WebSite\Definition\TitleDefinition;
use Moshas\WebSite\Pipe\LinkToNext;
use Moshas\WebSite\Pipe\Permalink;
use Moshas\WebSite\Pipe\Start;
use Moshas\WebSite\Definition\LinkDefinition;
use Moshas\WebSite\Pipe\WhileToNext;
use Moshas\WebSite\ScrapingDefinition;

require __DIR__ . '/../vendor/autoload.php';
$scraper = new \Moshas\WebSite\Scraper();
var_dump((new Crawler(array(
    new Start($scraper, new ScrapingDefinition('http://ishida-tak.sakura.ne.jp/wordpress/', array(new LinkDefinition('//div[@id="archives"]/ul/li/a'))),
        new WhileToNext($scraper, array(new LinkDefinition('//p[@class="next-posts"]/a')),
            new LinkToNext($scraper, array(new LinkDefinition('//div[@class="headline clearfix"]/h1/a')),
                new Permalink($scraper, array(new TitleDefinition('//div[@class="headline clearfix"]/h1'), new BodyDefinition('//div[@class="single_content"]'))
                )))))))->execute());

