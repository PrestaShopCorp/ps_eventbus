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

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use PrestaShop\Module\PsEventbus\Api\Post\MultipartBody;
use PrestaShop\Module\PsEventbus\Api\Post\PostFileApi;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CollectorApiClient
{
    /**
     * @var string
     */
    private $collectorApiUrl;

    /**
     * @var \Ps_eventbus
     */
    private $module;

    /**
     * Accounts JSON Web token
     *
     * @var string
     */
    private $jwt;

    /**
     * Default maximum execution time in seconds
     *
     * @see https://www.php.net/manual/en/info.configuration.php#ini.max-execution-time
     *
     * @var int
     */
    private static $DEFAULT_MAX_EXECUTION_TIME = 30;

    /**
     * @param string $collectorApiUrl
     * @param \Ps_eventbus $module
     * @param PsAccountsAdapterService $psAccountsAdapterService
     */
    public function __construct($collectorApiUrl, \Ps_eventbus $module, PsAccountsAdapterService $psAccountsAdapterService)
    {
        $this->module = $module;
        $this->jwt = $psAccountsAdapterService->getOrRefreshToken();
        $this->collectorApiUrl = $collectorApiUrl;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html
     * @see https://docs.guzzlephp.org/en/stable/request-options.html#read-timeout
     *
     * @param int $startTime @optional start time in seconds since epoch
     *
     * @return HttpClientInterface
     */
    private function getClient($startTime = null)
    {
        return (new ClientFactory())->getClient([
            'allow_redirects' => true,
            'connect_timeout' => 10,
            'http_errors' => false,
            'read_timeout' => 30,
            'timeout' => $this->getRemainingTime($startTime),
        ]);
    }

    /**
     * Push some ShopContents to CloudSync
     *
     * @param string $jobId
     * @param string $data
     * @param int $startTime in seconds since epoch
     * @param bool $fullSyncRequested
     *
     * @return array<mixed>
     */
    public function upload($jobId, $data, $startTime, $fullSyncRequested = null)
    {
        $url = $this->collectorApiUrl . '/upload/' . $jobId;

        // Prepare request
        $file = new PostFileApi('file', $data, 'file');
        $contentSize = $file->getContent()->getSize();
        $multipartBody = new MultipartBody([], [$file], Config::COLLECTOR_MULTIPART_BOUNDARY);

        $response = $this->getClient($startTime)->sendRequest(
            new Request(
                'POST',
                $url,
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'Content-Length' => $contentSize ? (string) $contentSize : '0',
                    'Content-Type' => 'multipart/form-data; boundary=' . Config::COLLECTOR_MULTIPART_BOUNDARY,
                    'Full-Sync-Requested' => $fullSyncRequested ? '1' : '0',
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
                $multipartBody->getContents()
            )
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => json_decode($response->getBody()->getContents(), true),
            'upload_url' => $url,
        ];
    }

    /**
     * Push information about removed ShopContents to CloudSync
     *
     * @param string $jobId
     * @param string $data
     * @param int $startTime in seconds since epoch
     *
     * @return array<mixed>
     */
    public function uploadDelete($jobId, $data, $startTime)
    {
        $url = $this->collectorApiUrl . '/delete/' . $jobId;
        // Prepare request
        $file = new PostFileApi('file', $data, 'file');
        $contentSize = $file->getContent()->getSize();
        $multipartBody = new MultipartBody([], [$file], Config::COLLECTOR_MULTIPART_BOUNDARY);

        $response = $this->getClient($startTime)->sendRequest(
            new Request(
                'POST',
                $url,
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'Content-Length' => $contentSize ? (string) $contentSize : '0',
                    'Content-Type' => 'multipart/form-data; boundary=' . Config::COLLECTOR_MULTIPART_BOUNDARY,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
                $multipartBody->getContents()
            )
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => json_decode($response->getBody()->getContents(), true),
            'upload_url' => $url,
        ];
    }

    /**
     * Get the remaining time of execution for the request. We keep a margin
     * of 1.5s to parse and answser our own client
     *
     * @param int $startTime @optional start time in seconds since epoch
     *
     * @return float
     */
    private function getRemainingTime($startTime = null)
    {
        /**
         * Negative remaining time means an immediate timeout (0 means infinity)
         *
         * @see https://docs.guzzlephp.org/en/stable/request-options.html?highlight=timeout#timeout
         */
        $maxExecutionTime = (int) ini_get('max_execution_time');
        if ($maxExecutionTime <= 0) {
            return CollectorApiClient::$DEFAULT_MAX_EXECUTION_TIME;
        }
        /*
         * An extra 1.5s to be arbitrary substracted
         * to keep time for the JSON parsing and state propagation in MySQL
         */
        $extraOpsTime = 1.5;

        /*
         * Default to maximum timeout
         */
        if (is_null($startTime)) {
            return $maxExecutionTime - $extraOpsTime;
        }

        $remainingTime = $maxExecutionTime - $extraOpsTime - (time() - $startTime);

        // A protection that might never be used, but who knows
        if ($remainingTime <= 0) {
            return CollectorApiClient::$DEFAULT_MAX_EXECUTION_TIME;
        }

        return $remainingTime;
    }
}
