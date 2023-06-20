<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

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
     * @param PsAccounts $psAccounts
     * @param string $collectorApiUrl
     * @param \Ps_eventbus $module
     */
    public function __construct($psAccounts, $collectorApiUrl, $module)
    {
        $this->module = $module;
        $this->jwt = $psAccounts->getPsAccountsService()->getOrRefreshToken();
        $this->collectorApiUrl = $collectorApiUrl;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html-
     *
     * @param int $startTime @optional start time in seconds since epoch
     *
     * @return HttpClientInterface
     */
    private function getClient(int $startTime = null)
    {
        return (new ClientFactory())->getClient([
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
        $payload = 'lines=' . urlencode($data);
        // Prepare request
        $request = new Request(
            'POST',
            $url,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->jwt,
                'Content-Length' => strlen($payload),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Full-Sync-Requested' => $fullSyncRequested ? '1' : '0',
                'User-Agent' => 'ps-eventbus/' . $this->module->version,
            ],
            $payload
        );

        // Send request and parse response
        $rawResponse = $this->getClient($startTime)->sendRequest($request);
        $jsonResponse = json_decode($rawResponse->getBody()->getContents(), true);
        $response = [
            'status' => substr((string) $rawResponse->getStatusCode(), 0, 1) === '2',
            'httpCode' => $rawResponse->getStatusCode(),
            'body' => $jsonResponse,
            'upload_url' => $url,
        ];

        return $response;
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
        $payload = 'lines=' . urlencode($data);
        // Prepare request
        $request = new Request(
            'POST',
            $url,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->jwt,
                'Content-Length' => strlen($payload),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => 'ps-eventbus/' . $this->module->version,
            ],
            $payload
        );

        // Send request and parse response
        $rawResponse = $this->getClient($startTime)->sendRequest($request);
        $jsonResponse = json_decode($rawResponse->getBody()->getContents(), true);
        $response = [
            'status' => substr((string) $rawResponse->getStatusCode(), 0, 1) === '2',
            'httpCode' => $rawResponse->getStatusCode(),
            'body' => $jsonResponse,
            'upload_url' => $url,
        ];

        return $response;
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
