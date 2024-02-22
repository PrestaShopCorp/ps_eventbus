<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Client;
use PrestaShop\Module\PsEventbus\Config\Config;

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
     */
    public function __construct($syncApiUrl, $module)
    {
        $this->module = $module;

        $psAccounts = \Module::getInstanceByName('ps_accounts');
        $psAccountsService = $psAccounts->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');

        $this->jwt = $psAccountsService->getOrRefreshToken();
        $this->shopId = $psAccountsService->getShopUuid();
        $this->syncApiUrl = $syncApiUrl;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html-
     *
     * @param int $timeout
     *
     * @return GuzzleClient
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
        $rawResponse = $this->getClient()->createRequest(
            'GET',
            $this->syncApiUrl . '/job/' . $jobId,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ],
            ]
        )->send();

        $jsonResponse = json_decode($rawResponse);
        
        dump($rawResponse,
        $this->syncApiUrl . '/job/' . $jobId,
        [
            'method' => 'GET',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->jwt,
                'User-Agent' => 'ps-eventbus/' . $this->module->version,
            ],
        ]);

        return [
            'status' => substr((string) $jsonResponse->statusCode, 0, 1) === '2',
            'httpCode' => $jsonResponse->statusCode,
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
        $rawResponse = $this->getClient(3)->request(
            $this->syncApiUrl . '/notify/' . $this->shopId,
            [
                'method' => 'POST',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    'Content-Type' => 'application/json',
                ],
                'body' => '{"shopContents":' . json_encode($shopContent) . ', "shopContentId": ' . $shopContentId . ', "action": "' . $action . '"}',
            ]
        );

        $jsonResponse = json_decode($rawResponse);

        return [
            'status' => substr((string) $jsonResponse->statusCode, 0, 1) === '2',
            'httpCode' => $jsonResponse->statusCode,
            'body' => $jsonResponse->body,
        ];
    }
}
