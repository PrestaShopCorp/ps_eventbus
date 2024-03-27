<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;

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
     * @param PsAccountsAdapterService $psAccountsAdapterService
     */
    public function __construct(string $syncApiUrl, \Ps_eventbus $module, PsAccountsAdapterService $psAccountsAdapterService)
    {
        $this->module = $module;
        $this->jwt = $psAccountsAdapterService->getOrRefreshToken();
        $this->shopId = $psAccountsAdapterService->getShopUuid();
        $this->syncApiUrl = $syncApiUrl;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html-
     *
     * @param int $timeout
     *
     * @return HttpClientInterface
     */
    private function getClient($timeout = Config::SYNC_API_MAX_TIMEOUT)
    {
        return (new ClientFactory())->getClient([
            'allow_redirects' => true,
            'connect_timeout' => 10,
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
        $response = $this->getClient()->sendRequest(
            new Request(
                'GET',
                $this->syncApiUrl . '/job/' . $jobId,
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                ]
            )
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
        $response = $this->getClient(3)->sendRequest(
            new Request(
                'POST',
                $this->syncApiUrl . '/notify/' . $this->shopId,
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    'Content-Type' => 'application/json',
                ],
                '{"shopContents":' . json_encode($shopContent) . ', "shopContentId": ' . $shopContentId . ', "action": "' . $action . '"}'
            )
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => $response->getBody(),
        ];
    }
}
