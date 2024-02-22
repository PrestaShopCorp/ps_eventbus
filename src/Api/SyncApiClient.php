<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Client;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\PsAccountsService;

class SyncApiClient
{
    /**
     * @var string
     */
    private $syncApiUrl;

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
     * Accounts Shop UUID
     *
     * @var string
     */
    private $shopId;

    /**
     * @param string $syncApiUrl
     * @param \Ps_eventbus $module
     * @param PsAccountsService
     */
    public function __construct($syncApiUrl, $module, $psAccountsService)
    {
        $this->module = $module;
        $this->jwt = $psAccountsService->getOrRefreshToken();
        $this->shopId = $psAccountsService->getShopUuid();
        $this->syncApiUrl = $syncApiUrl;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html-
     *
     * @param int $timeout
     *
     * @return Client
     */
    private function getClient($timeout = Config::SYNC_API_MAX_TIMEOUT)
    {
        return new Client([
            'allow_redirects' => true,
            'connect_timeout' => 3,
            'http_errors' => false,
            'timeout' => $timeout,
        ]);
    }

    /**
     * @param string $jobId
     *
     * @return array|bool
     */
    public function validateJobId($jobId)
    {
        $response = $this->getClient()->request(
            'GET',
            $this->syncApiUrl . '/job/' . $jobId,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
            ]
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
        ];
    }

    /**
     * @param array $shopContent
     * @param int $shopContentId
     * @param string $action
     *
     * @return array
     */
    public function liveSync($shopContent, $shopContentId, $action)
    {
        $response = $this->getClient(3)->request(
            'POST',
            $this->syncApiUrl . '/notify/' . $this->shopId,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    'Content-Type' => 'application/json',
                ],
                'body' => '{"shopContents":' . json_encode($shopContent) . ', "shopContentId": ' . $shopContentId . ', "action": "' . $action . '"}',
            ]
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => $response->getBody(),
        ];
    }
}
