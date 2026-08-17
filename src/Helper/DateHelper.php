<?php

namespace PrestaShop\Module\PsEventbus\Helper;

use PrestaShop\Module\PsEventbus\Config\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

class DateHelper
{
    /**
     * Normalizes any date representation into the format expected by our
     * `DATETIME` columns.
     *
     * MySQL only tolerates ISO 8601 values such as `2026-08-13T11:26:59+02:00`
     * when the server runs in a permissive `sql_mode`: it silently truncates
     * them and raises a warning. With `STRICT_TRANS_TABLES` enabled (the
     * default since MySQL 5.7) the very same insert fails with
     * "Incorrect datetime value", so every date must be normalized before it
     * reaches a query.
     *
     * The wall clock of the incoming value is preserved as-is: no timezone
     * conversion happens, only a reformat.
     *
     * @param string|null $date
     *
     * @return string date formatted as `Y-m-d H:i:s`, current date when the
     *                given value cannot be used
     */
    public static function toMySqlDateTime($date)
    {
        if (!is_string($date) || trim($date) === '') {
            return date(Config::MYSQL_DATE_FORMAT);
        }

        // date_create() returns false on an unparseable string where the
        // \DateTime constructor throws, which keeps this helper exception-free
        $dateTime = date_create($date);

        if ($dateTime === false) {
            return date(Config::MYSQL_DATE_FORMAT);
        }

        // zero dates ('0000-00-00 00:00:00') are parsed but stay out of the
        // range MySQL accepts in strict mode
        if ((int) $dateTime->format('Y') < 1000) {
            return date(Config::MYSQL_DATE_FORMAT);
        }

        return $dateTime->format(Config::MYSQL_DATE_FORMAT);
    }
}
