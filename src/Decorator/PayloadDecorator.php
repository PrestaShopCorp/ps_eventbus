<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Decorator;

// use hardcoded format to avoid problems with interface change in PHP 7.2
const ISO8601 = 'Y-m-d\TH:i:sO';
const DATE_FIELDS = [
    'created_at',
    'updated_at',
    'last_connection_date',
    'folder_created_at',
    'date_add',
    'newsletter_date_add',
    'from',
    'to',
];

if (!defined('_PS_VERSION_')) {
    exit;
}

class PayloadDecorator
{
    /**
     * @var string
     */
    private $timezone;

    public function __construct()
    {
        $this->timezone = (string) \Configuration::get('PS_TIMEZONE');
    }

    /**
     * @param array<mixed> $payload
     *
     * @return void
     *
     * @throws \Exception
     */
    public function convertDateFormat(&$payload)
    {
        foreach ($payload as &$payloadItem) {
            foreach (DATE_FIELDS as $dateField) {
                if (isset($payloadItem['properties'][$dateField])) {
                    $date = &$payloadItem['properties'][$dateField];
                    if (!empty($date) && $date !== '0000-00-00 00:00:00') {
                        $dateTime = new \DateTime($date, new \DateTimeZone($this->timezone));
                        $date = $dateTime->format(ISO8601);
                    } else {
                        $date = null;
                    }
                }
            }
        }
    }
}
