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

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CommonService
{
    /**
     * @param mixed $response
     *
     * @return void
     */
    public static function exitWithResponse($response)
    {
        if (!is_array($response)) {
            $response = [$response];
        }

        $httpCode = isset($response['httpCode']) ? (int) $response['httpCode'] : 200;

        self::dieWithResponse($response, $httpCode);
    }

    /**
     * @param \Exception $exception
     *
     * @return void
     */
    public static function exitWithExceptionMessage(\Exception $exception)
    {
        switch ($exception) {
            case $exception instanceof \PrestaShopDatabaseException:
                $code = Config::DATABASE_QUERY_ERROR_CODE;
                break;
            case $exception instanceof EnvVarException:
                $code = Config::ENV_MISCONFIGURED_ERROR_CODE;
                break;
            case $exception instanceof FirebaseException:
                $code = Config::REFRESH_TOKEN_ERROR_CODE;
                break;
            case $exception instanceof QueryParamsException:
                $code = Config::INVALID_URL_QUERY;
                break;
            default:
                $code = 500;
        }

        $response = [
            'object_type' => \Tools::getValue('shopContent'),
            'status' => false,
            'httpCode' => $code,
            'message' => $code == 500 ? 'Server error' : $exception->getMessage(),
        ];

        self::dieWithResponse($response, (int) $code);
    }

    /**
     * @param array<mixed> $response
     * @param int $code
     *
     * @return void
     */
    public static function dieWithResponse($response, $code)
    {
        $httpStatusText = "HTTP/1.1 $code";

        if (array_key_exists((int) $code, Config::HTTP_STATUS_MESSAGES)) {
            $httpStatusText .= ' ' . Config::HTTP_STATUS_MESSAGES[(int) $code];
        } elseif (isset($response['body']['statusText'])) {
            $httpStatusText .= ' ' . $response['body']['statusText'];
        }

        $response['httpCode'] = (int) $code;

        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/json;charset=utf-8');
        header($httpStatusText);

        echo json_encode($response, JSON_UNESCAPED_SLASHES);

        exit;
    }

    /**
     * @param array<mixed> $payload
     *
     * @return void
     *
     * @throws \Exception
     */
    public static function convertDateFormat(&$payload)
    {
        // use hardcoded format to avoid problems with interface change in PHP 7.2
        $ISO8601 = 'Y-m-d\TH:i:sO';
        $dateFields = [
            'created_at',
            'updated_at',
            'last_connection_date',
            'folder_created_at',
            'date_add',
            'newsletter_date_add',
            'from',
            'to',
        ];

        $timezone = (string) \Configuration::get('PS_TIMEZONE');

        foreach ($payload as &$payloadItem) {
            foreach ($dateFields as $dateField) {
                if (isset($payloadItem['properties'][$dateField])) {
                    $date = &$payloadItem['properties'][$dateField];
                    if (!empty($date) && $date !== '0000-00-00 00:00:00') {
                        $dateTime = new \DateTime($date, new \DateTimeZone($timezone));
                        $date = $dateTime->format($ISO8601);
                    } else {
                        $date = null;
                    }
                }
            }
        }
    }
}
