<?php
namespace Moshas\WebSite;


class FieldDefinition
{
    private $query = null;
    private $settingTo = null;
    private $dataAs = null;
    private $dataFrom = null;
    private $attributeName = null;

    const DATA_FROM_TEXT = 1;
    const DATA_FROM_ATTRIBUTE = 2;

    const DATA_AS_HTML = 11;
    const DATA_AS_TEXT = 12;

    const SETTING_TO_SUBJECT = 21;
    const SETTING_TO_BODY = 22;
    const SETTING_TO_DATE = 23;
    const SETTING_TO_AUTHOR = 24;
    const SETTING_TO_URL = 25;

    /**
     * ScrapingDefinition constructor.
     * @param null $query
     * @param int $settingTo
     * @param int $dataAs
     * @param int $dataFrom
     * @param null $attributeName
     * @throws \InvalidArgumentException
     */
    public function __construct($query, $settingTo = self::SETTING_TO_BODY, $dataAs = self::DATA_AS_TEXT, $dataFrom = self::DATA_FROM_TEXT, $attributeName = null)
    {
        $this->query = $query;
        $this->settingTo = $settingTo;
        $this->dataAs = $dataAs;
        $this->dataFrom = $dataFrom;
        $this->attributeName = $attributeName;
        if ($this->settingTo >= 30 || $this->settingTo < 21) {
            throw new \InvalidArgumentException('invalid settingTo');
        }
        if ($this->dataAs >= 20 || $this->settingTo < 11) {
            throw new \InvalidArgumentException('invalid dataAs');
        }
        if ($this->dataFrom >= 10 || $this->dataFrom < 1) {
            throw new \InvalidArgumentException('invalid dataFrom');
        }
        if ($this->dataFrom === self::DATA_FROM_ATTRIBUTE && ($this->attributeName === null || $this->attributeName === '')) {
            throw new \InvalidArgumentException('need attributeName');
        }
    }

    /**
     * @return null
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return int|null
     */
    public function getSettingTo()
    {
        return $this->settingTo;
    }

    /**
     * @return int|null
     */
    public function getDataAs()
    {
        return $this->dataAs;
    }

    /**
     * @return int|null
     */
    public function getDataFrom()
    {
        return $this->dataFrom;
    }

    /**
     * @return null
     */
    public function getAttributeName()
    {
        return $this->attributeName;
    }

    public function setTo($text, $entity)
    {
        if (!$text) return ;
        if ($this->getSettingTo() === FieldDefinition::SETTING_TO_BODY) {
            $entity->setBody($text);
        } elseif ($this->getSettingTo() === FieldDefinition::SETTING_TO_SUBJECT) {
            $entity->setSubject($text);
        } elseif ($this->getSettingTo() === FieldDefinition::SETTING_TO_URL) {
            $entity->setUrl($text);
        } elseif ($this->getSettingTo() === FieldDefinition::SETTING_TO_DATE) {
            $entity->setCreatedAt($text);
        } elseif ($this->getSettingTo() === FieldDefinition::SETTING_TO_AUTHOR) {
            $entity->setUserName($text);
        }
    }

    public function buildData($item)
    {
        $text = '';
        if ($this->getDataFrom() === FieldDefinition::DATA_FROM_TEXT) {
            if ($this->getDataAs() === FieldDefinition::DATA_AS_HTML) {
                $text = $item->saveHTML();
            } elseif ($this->getDataAs() === FieldDefinition::DATA_AS_TEXT) {
                $text = $item->textContent;
            }
        } elseif ($this->getDataFrom() === FieldDefinition::DATA_FROM_ATTRIBUTE) {
            $attributes = $item->attributes;
            if ($attributes === null || $attributes->length === 0) return $text;
            for ($j = 0; $j < $attributes->length; $j++) {
                if ($attributes->item($j)->name !== $this->getAttributeName()) continue;
                $text .= $attributes->item($j)->nodeValue;
            }
        }
        return $text;
    }
}