<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use PrestaShop\Module\PsEventbus\Api\Post\MultipartBody;
use PrestaShop\Module\PsEventbus\Api\Post\PostFileApi;
use PrestaShop\Module\PsEventbus\Config\Config;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

class CollectorApiClient
{
    /**
     * @var HttpClientInterface
     */
    private $client;

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

        // @see https://docs.guzzlephp.org/en/stable/quickstart.html
        $this->client = (new ClientFactory())->getClient([
            'allow_redirects' => true,
            'base_uri' => $collectorApiUrl,
            'connect_timeout' => 3,
            'http_errors' => false,
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
        // Prepare request
        $file = new PostFileApi('file', $data, 'file');
        $multipartBody = new MultipartBody([], [$file], Config::COLLECTOR_MULTIPART_BOUNDARY);
        $request = new Request(
            'POST',
            '/upload/' . $jobId,
            [
                'timeout' => $this->getRemainingTime($startTime),
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $this->jwt",
                    'Content-Length' => $file->getContent()->getSize(),
                    'Content-Type' => 'multipart/form-data; boundary=' . Config::COLLECTOR_MULTIPART_BOUNDARY,
                    'Full-Sync-Requested' => $fullSyncRequested ? '1' : '0',
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
            ],
            $multipartBody->getContents()
        );

        // Send request and parse response
        $rawResponse = $this->client->sendRequest($request);
        $jsonResponse = json_decode($rawResponse->getBody()->getContents(), true);
        $response = [
            'status' => substr((string) $rawResponse->getStatusCode(), 0, 1) === '2',
            'httpCode' => $rawResponse->getStatusCode(),
            'body' => $jsonResponse,
            'upload_url' => $request->getUri(),
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
        // Prepare request
        $file = new PostFileApi('file', $data, 'file');
        $multipartBody = new MultipartBody([], [$file], Config::COLLECTOR_MULTIPART_BOUNDARY);
        $request = new Request(
            'POST',
            '/delete/' . $jobId,
            [
                'timeout' => $this->getRemainingTime($startTime),
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $this->jwt",
                    'Content-Length' => $file->getContent()->getSize(),
                    'Content-Type' => 'multipart/form-data; boundary=' . Config::COLLECTOR_MULTIPART_BOUNDARY,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
            ],
            $multipartBody->getContents()
        );

        // Send request and parse response
        $rawResponse = $this->client->sendRequest($request);
        $jsonResponse = json_decode($rawResponse->getBody()->getContents(), true);
        $response = [
            'status' => substr((string) $rawResponse->getStatusCode(), 0, 1) === '2',
            'httpCode' => $rawResponse->getStatusCode(),
            'body' => $jsonResponse,
            'upload_url' => $request->getUri(),
        ];

        return $response;
    }

    /**
     * Get the remaining time of execution for the request. We keep a margin
     * of 1.5s to parse and answser our own client
     *
     * @param int $startTime in seconds since epoch
     *
     * @return float
     */
    public function getRemainingTime(int $startTime)
    {
        $remainingTime = time() - $startTime;
        if ($remainingTime <= 0) {
            return 0;
        }

        return $remainingTime - Config::COLLECTOR_MAX_TIMEOUT - 1.5;
    }
}
