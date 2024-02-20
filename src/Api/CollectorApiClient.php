<?php

namespace PrestaShop\Module\PsEventbus\Api;


use PrestaShop\CircuitBreaker\Client\GuzzleClient;
use PrestaShop\Module\PsEventbus\Api\Post\MultipartBody;
use PrestaShop\Module\PsEventbus\Api\Post\PostFileApi;
use PrestaShop\Module\PsEventbus\Config\Config;
use \PrestaShop\PrestaShop\Adapter\Entity\Module;

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
     * @param string $collectorApiUrl
     * @param \Ps_eventbus $module
     */
    public function __construct($collectorApiUrl, $module)
    {
        $this->module = $module;

        $psAccounts = Module::getInstanceByName('ps_accounts');
        $psAccountsService = $psAccounts->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');

        $this->jwt = $psAccountsService->getOrRefreshToken();
        $this->collectorApiUrl = $collectorApiUrl;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html-
     *
     * @param int $startTime @optional start time in seconds since epoch
     *
     * @return GuzzleClient
     */
    private function getClient(int $startTime = null)
    {
        return new GuzzleClient([
            'allow_redirects' => true,
            'connect_timeout' => 3,
            'http_errors' => false,
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
     * @return array
     */
    public function upload(string $jobId, string $data, int $startTime, bool $fullSyncRequested = false)
    {
        $url = $this->collectorApiUrl . '/upload/' . $jobId;

        // Prepare request
        $file = new PostFileApi('file', $data, 'file');
        $contentSize = $file->getContent()->getSize();
        $multipartBody = new MultipartBody([], [$file], Config::COLLECTOR_MULTIPART_BOUNDARY);

        $rawResponse = $this->getClient($startTime)->request(
            $url,
            [
                'method' => 'POST',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'Content-Length' => $contentSize ? (string) $contentSize : '0',
                    'Content-Type' => 'multipart/form-data; boundary=' . Config::COLLECTOR_MULTIPART_BOUNDARY,
                    'Full-Sync-Requested' => $fullSyncRequested ? '1' : '0',
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
                'body' => $multipartBody->getContents(),
            ]
        );

        $jsonResponse = json_decode($rawResponse);

        return [
            'status' => substr((string) $jsonResponse->statusCode, 0, 1) === '2',
            'httpCode' => $jsonResponse->statusCode,
            'body' => $jsonResponse->body,
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
     * @return array
     */
    public function uploadDelete(string $jobId, string $data, int $startTime)
    {
        $url = $this->collectorApiUrl . '/delete/' . $jobId;
        // Prepare request
        $file = new PostFileApi('file', $data, 'file');
        $contentSize = $file->getContent()->getSize();
        $multipartBody = new MultipartBody([], [$file], Config::COLLECTOR_MULTIPART_BOUNDARY);

        $rawResponse = $this->getClient($startTime)->request(
            $url,
            [
                'method' => 'POST',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'Content-Length' => $contentSize ? (string) $contentSize : '0',
                    'Content-Type' => 'multipart/form-data; boundary=' . Config::COLLECTOR_MULTIPART_BOUNDARY,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
                'body' => $multipartBody->getContents(),
            ]
        );

        $jsonResponse = json_decode($rawResponse);

        return [
            'status' => substr((string) $jsonResponse->statusCode, 0, 1) === '2',
            'httpCode' => $jsonResponse->statusCode,
            'body' => $jsonResponse->body,
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
    private function getRemainingTime(int $startTime = null)
    {
        /*
         * An extra 1.5s to be arbitrary substracted
         * to keep time for the JSON parsing and state propagation in MySQL
         */
        $extraOpsTime = 1.5;

        /*
         * Default to maximum timeout
         */
        if (is_null($startTime)) {
            return (int) ini_get('max_execution_time') - $extraOpsTime;
        }

        $remainingTime = (int) ini_get('max_execution_time') - $extraOpsTime - (time() - $startTime);

        /*
         * Negative remaining time means an immediate timeout (0 means infinity)
         * @see https://docs.guzzlephp.org/en/stable/request-options.html?highlight=timeout#timeout
         */
        if ($remainingTime <= 0) {
            return 0.1;
        }

        return $remainingTime;
    }
}
