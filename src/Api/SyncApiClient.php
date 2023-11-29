<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use PrestaShop\Module\PsEventbus\Config\Config;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

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
     * @param PsAccounts $psAccounts
     * @param string $syncApiUrl
     * @param \Ps_eventbus $module
     */
    public function __construct($psAccounts, $syncApiUrl, $module)
    {
        $this->module = $module;
        $this->jwt = $psAccounts->getPsAccountsService()->getOrRefreshToken();
        $this->shopId = $psAccounts->getPsAccountsService()->getShopUuid();
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
        $rawResponse = $this->getClient()->sendRequest(
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
            'status' => substr((string) $rawResponse->getStatusCode(), 0, 1) === '2',
            'httpCode' => $rawResponse->getStatusCode(),
        ];
    }

    /**
     * @param array $shopContents
     * @param int $shopContentId
     * @param string $action
     *
     * @return array
     */
    public function liveSync($shopContents, $shopContentId, $action)
    {
        $rawResponse = $this->getClient(3)->sendRequest(
            new Request(
                'POST',
                $this->syncApiUrl . '/notify/' . $this->shopId,
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    'Content-Type' => 'application/json',
                ],
                '{"shopContents":' . json_encode($shopContents) . ', "shopContentId": ' . $shopContentId . ', "action": "' . $action . '"}'
            )
        );

        return [
            'status' => substr((string) $rawResponse->getStatusCode(), 0, 1) === '2',
            'httpCode' => $rawResponse->getStatusCode(),
            'body' => $rawResponse->getBody(),
        ];
    }
}
