<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use PrestaShop\Module\PsEventbus\Api\Post\MultipartBody;
use PrestaShop\Module\PsEventbus\Api\Post\PostFileApi;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;

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
     * <<<<<<< HEAD
     * =======
     *
     * >>>>>>> 7357fb2f5f39bff81f9a01000304c714dad82fe9
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
    public function __construct(string $collectorApiUrl, \Ps_eventbus $module, PsAccountsAdapterService $psAccountsAdapterService)
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
    private function getClient(int $startTime = null)
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
     * @return array
     */
    public function upload(string $jobId, string $data, int $startTime, bool $fullSyncRequested = false)
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
     * @return array
     */
    public function uploadDelete(string $jobId, string $data, int $startTime)
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
    private function getRemainingTime(int $startTime = null)
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
