<?php

namespace PrestaShop\Module\PsEventbus\Api;

use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;

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
     * @param PsAccountsAdapterService $psAccountsAdapterService
     */
    public function __construct($liveSyncApiUrl, \Ps_eventbus $module, PsAccountsAdapterService $psAccountsAdapterService)
    {
        $this->module = $module;
        $this->jwt = $psAccountsAdapterService->getOrRefreshToken();
        $this->shopId = $psAccountsAdapterService->getShopUuid();
        $this->liveSyncApiUrl = $liveSyncApiUrl;
    }

    /**
     * @param string $shopContent
     * @param int $shopContentId
     * @param string $action
     *
     * @return array<mixed>
     */
    public function liveSync($shopContent, $shopContentId, $action)
    {
        // shop content send to the API must be in kebab-case
        $kebabCasedShopContent = str_replace('_', '-', $shopContent);

        $client = new HttpClientFactory(3);

        $response = $client->sendRequest(
            'POST',
            $this->liveSyncApiUrl . '/notify/' . $this->shopId,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->jwt,
                'User-Agent' => 'ps-eventbus/' . $this->module->version,
                'Content-Type' => 'application/json',
            ],
            '{"shopContents": ["' . $kebabCasedShopContent . '"], "shopContentId": ' . $shopContentId . ', "action": "' . $action . '"}'
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => $response->getBody(),
        ];
    }
}
