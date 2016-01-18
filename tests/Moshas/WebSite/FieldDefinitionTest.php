<?php
namespace Moshas\WebSite;
use Moshas\Entity;

class FieldDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testSetToBody()
    {
        $entity = new Entity();
        $def = new FieldDefinition('hoge');
        $def->setTo('hoge', $entity);
        $this->assertSame('hoge', $entity->getBody());
    }

    public function testSetToSubject()
    {
        $entity = new Entity();
        $def = new FieldDefinition('hoge', FieldDefinition::SETTING_TO_SUBJECT);
        $def->setTo('hoge', $entity);
        $this->assertSame('hoge', $entity->getSubject());
    }

    public function testSetToUrl()
    {
        $entity = new Entity();
        $def = new FieldDefinition('hoge', FieldDefinition::SETTING_TO_URL);
        $def->setTo('hoge', $entity);
        $this->assertSame('hoge', $entity->getUrl());
    }

    public function testSetToAuthor()
    {
        $entity = new Entity();
        $def = new FieldDefinition('hoge', FieldDefinition::SETTING_TO_AUTHOR);
        $def->setTo('hoge', $entity);
        $this->assertSame('hoge', $entity->getUserName());
    }

    public function testSetToDateTime()
    {
        $entity = new Entity();
        $def = new FieldDefinition('hoge', FieldDefinition::SETTING_TO_DATE);
        $def->setTo('hoge', $entity);
        $this->assertSame('hoge', $entity->getCreatedAt());
    }

    public function testBuildDataText()
    {
        $def = new FieldDefinition('hoge');
        $dom = new \DOMDocument();
        $dom->loadHTML('<html><body>hoge</body></html>');
        $this->assertSame('hoge', $def->buildData($dom));
    }

    public function testBuildDataHtml()
    {
        $def = new FieldDefinition('hoge', FieldDefinition::SETTING_TO_BODY, FieldDefinition::DATA_AS_HTML);
        $dom = new \DOMDocument();
        $dom->loadHTML('<html><body>hoge</body></html>');
        $this->assertSame(
            '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">' . "\n" .
            '<html><body>hoge</body></html>' . "\n",
            $def->buildData($dom)
        );
    }

    public function testBuildDataAttribute()
    {
        $dom = new \DOMDocument();
        $dom->loadHTML('<a href="http://ishida-tak.sakura.ne.jp">hoge</a>');
        $tag = $dom->getElementsByTagName('a')[0];
        $def = new FieldDefinition('hoge', FieldDefinition::SETTING_TO_BODY, FieldDefinition::DATA_AS_TEXT, FieldDefinition::DATA_FROM_ATTRIBUTE, 'href');
        $this->assertSame('http://ishida-tak.sakura.ne.jp', $def->buildData($tag));
    }
}
