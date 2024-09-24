<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;

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
        $code = $exception->getCode() == 0 ? 500 : $exception->getCode();

        if ($exception instanceof \PrestaShopDatabaseException) {
            $code = Config::DATABASE_QUERY_ERROR_CODE;
        } elseif ($exception instanceof EnvVarException) {
            $code = Config::ENV_MISCONFIGURED_ERROR_CODE;
        } elseif ($exception instanceof FirebaseException) {
            $code = Config::REFRESH_TOKEN_ERROR_CODE;
        } elseif ($exception instanceof QueryParamsException) {
            $code = Config::INVALID_URL_QUERY;
        }

        $response = [
            'object_type' => \Tools::getValue('shopContent'),
            'status' => false,
            'httpCode' => $code,
            'message' => $exception->getMessage(),
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
}
