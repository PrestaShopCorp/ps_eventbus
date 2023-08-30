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
     * @param array $data
     * @param int $startTime in seconds since epoch
     * @param bool $fullSyncRequested
     *
     * @return array
     */
    public function upload(string $jobId, array $data, int $startTime, bool $fullSyncRequested = false)
    {
        $url = $this->collectorApiUrl . '/upload/' . $jobId;
        $request = $this->postJson($url, $data, [
            'Full-Sync-Requested' => $fullSyncRequested ? '1' : '0',
        ]);
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
     * @param array $data
     * @param int $startTime in seconds since epoch
     *
     * @return array
     */
    public function uploadDelete(string $jobId, array $data, int $startTime)
    {
        $url = $this->collectorApiUrl . '/delete/' . $jobId;
        $request = $this->postJson($url, $data);
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
     * Forge a request to POST serialized JSON
     *
     * @param string $url
     * @param array $data
     * @param array $extraHeaders (optional)
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    private function postJson(string $url, array $data, array $extraHeaders = [])
    {
        $headers = array_merge($extraHeaders, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->jwt,
            'Content-Type' => 'application/json',
            'User-Agent' => 'ps-eventbus/' . $this->module->version,
        ]);

        $jsonData = json_encode($data, JSON_UNESCAPED_SLASHES);

        if (extension_loaded('zlib')) {
            $encodedData = gzencode($jsonData);
            if (!$encodedData) {
                throw new \Exception('Failed encoding data to GZIP');
            }
            $headers['Content-Encoding'] = 'gzip';
            $jsonData = $encodedData;
        }
        $headers['Content-Length'] = strlen($jsonData);

        return new Request(
            'POST',
            $url,
            $headers,
            $jsonData
        );
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
