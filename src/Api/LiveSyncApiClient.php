<?php

namespace PrestaShop\Module\PsEventbus\Api;

use PrestaShop\CircuitBreaker\Client\GuzzleClient;
use PrestaShop\Module\PsEventbus\Config\Config;

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
     * @param \Ps_eventbus $module
     */
    public function __construct($liveSyncApiUrl, $module)
    {
        $this->module = $module;

        $psAccounts = \PrestaShop\PrestaShop\Adapter\Entity\Module::getInstanceByName('ps_accounts');
        $psAccountsService = $psAccounts->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');

        $this->jwt = $psAccountsService->getOrRefreshToken();
        $this->shopId = $psAccountsService->getShopUuid();
        $this->liveSyncApiUrl = $liveSyncApiUrl;
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
        return new GuzzleClient([
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
        $rawResponse = $this->getClient(3)->request(
            $this->liveSyncApiUrl . '/notify/' . $this->shopId,
            [
                'method' => 'POST',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    'Content-Type' => 'application/json',
                ],
                'body' => '{"shopContents": ["' . $shopContent . '"], "shopContentId": ' . $shopContentId . ', "action": "' . $action . '"}',
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
