<?php
use Moshas\Crawler;
use Moshas\WebSite\Definition\BodyDefinition;
use Moshas\WebSite\Definition\TitleDefinition;
use Moshas\WebSite\Pipe\LinkToNext;
use Moshas\WebSite\Pipe\Permalink;
use Moshas\WebSite\Pipe\Start;
use Moshas\WebSite\Definition\LinkDefinition;
use Moshas\WebSite\ScrapingDefinition;

require __DIR__ . '/../vendor/autoload.php';
$scraper = new \Moshas\WebSite\Scraper();
var_dump((new Crawler(array(
    new Start($scraper, new ScrapingDefinition('http://ishida-tak.sakura.ne.jp/wordpress/', array(
            new LinkDefinition('//div[@id="archives"]/ul/li/a'),
        )),
        new LinkToNext($scraper, array(new LinkDefinition('//div[@class="headline clearfix"]/h1/a')),
            new Permalink($scraper, array (
                // new LinkDefinition('//div[@class="headline clearfix"]/h1/a'),
                new TitleDefinition('//div[@class="headline clearfix"]/h1'),
                new BodyDefinition('//div[@class="single_content"]'),
            )))))))->execute());
/*
var_dump($scraper->scrape(
    new \Moshas\WebSite\ScrapingDefinition(
        'http://ishida-tak.sakura.ne.jp/wordpress/',
        array(
            new \Moshas\WebSite\FieldDefinition('//div[@class="headline clearfix"]/h1/a', \Moshas\WebSite\FieldDefinition::SETTING_TO_SUBJECT),
            new \Moshas\WebSite\FieldDefinition(
                \Moshas\WebSite\FieldDefinition::SETTING_TO_URL,
                \Moshas\WebSite\FieldDefinition::DATA_AS_TEXT,
                \Moshas\WebSite\FieldDefinition::DATA_FROM_ATTRIBUTE,
                'href'
            ),
            new \Moshas\WebSite\FieldDefinition('//div[@class="excerpt"]', \Moshas\WebSite\FieldDefinition::SETTING_TO_BODY),
        )
    )));
*/
