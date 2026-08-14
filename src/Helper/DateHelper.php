<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

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

        try {
            $dateTime = new \DateTime($date);
        } catch (\Exception $exception) {
            return date(Config::MYSQL_DATE_FORMAT);
        }

        // zero dates ('0000-00-00 00:00:00') are parsed by \DateTime but stay
        // out of the range MySQL accepts in strict mode
        if ((int) $dateTime->format('Y') < 1000) {
            return date(Config::MYSQL_DATE_FORMAT);
        }

        return $dateTime->format(Config::MYSQL_DATE_FORMAT);
    }
}
