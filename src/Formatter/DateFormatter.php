<?php

namespace PrestaShop\Module\PsEventbus\Formatter;

use DateTime;
use Exception;

class DateFormatter
{
    /**
     * @param string $date
     *
     * @return string
     */
    public function convertToIso8061($date)
    {
        try {
            return (new DateTime($date))->format(DateTime::ISO8601);
        } catch (Exception $e) {
            return $date;
        }
    }
}
