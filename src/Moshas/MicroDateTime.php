<?php
/**
 * Date: 15/12/17
 * Time: 15:55.
 */

namespace Moshas;


use DateTime;
use DateTimeZone;

class MicroDateTime extends \DateTime
{
    private $microTime = null;
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
        if ($time === 'now') {
            $this->microTime = microtime();
        }
    }

    public function format($format)
    {
        if (strpos($format, 'u') !== false) {
            $timeList = explode(' ', $this->microTime);
            $timeMicro = explode('.', $timeList[0]);
            $format = str_replace('u', $timeMicro, $format);
        }
        parent::format($format);
    }


    /**
     * @param null|string $microTime
     */
    public function setMicroTime($microTime)
    {
        $this->microTime = $microTime;
    }

    /**
     * @return null|string
     */
    public function getMicroTime()
    {
        return $this->microTime;
    }
}