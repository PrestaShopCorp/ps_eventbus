<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Client;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\PsAccountsService;
use Ps_eventbus;

class LiveSyncApiClient
{
    /**
     * @var string
     */
    private $liveSyncApiUrl;

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
     * @param string $liveSyncApiUrl
     * @param Ps_eventbus $module
     * @param PsAccountsService $psAccountsService
     */
    public function __construct(string $liveSyncApiUrl, Ps_eventbus $module, PsAccountsService $psAccountsService)
    {
        $this->module = $module;
        $this->jwt = $psAccountsService->getOrRefreshToken();
        $this->shopId = $psAccountsService->getShopUuid();
        $this->liveSyncApiUrl = $liveSyncApiUrl;
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
     * @param string $shopContent
     * @param int $shopContentId
     * @param string $action
     *
     * @return array
     */
    public function liveSync(string $shopContent, int $shopContentId, string $action)
    {
        $response = $this->getClient(3)->request(
            'POST',
            $this->liveSyncApiUrl . '/notify/' . $this->shopId,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    'Content-Type' => 'application/json',
                ],
                'body' => '{"shopContents": ["' . $shopContent . '"], "shopContentId": ' . $shopContentId . ', "action": "' . $action . '"}',
            ]
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => $response->getBody(),
        ];
    }
}
