<?php
namespace Moshas\WebSite;


class FieldDefinition
{
    private $query     = null;
    private $settingTo = self::SETTING_TO_BODY;
    private $dataAs    = self::DATA_AS_TEXT;
    private $dataFrom  = self::DATA_FROM_TEXT;
    private $attributeName = null;

    const DATA_FROM_TEXT      = 1;
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
     */
    public function __construct($query, $settingTo = null, $dataAs = null, $dataFrom = null, $attributeName = null)
    {
        $this->query = $query;
        if ($settingTo) {
            $this->settingTo = $settingTo;
        }
        if ($dataAs) {
            $this->dataAs = $dataAs;
        }
        if ($dataFrom) {
            $this->dataFrom = $dataFrom;
        }
        $this->attributeName = $attributeName;
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
}