<?php

namespace PrestaShop\Module\PsEventbus\Api;

use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;

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
     * @param string $syncApiUrl
     * @param \Ps_eventbus $module
     * @param PsAccountsAdapterService $psAccountsAdapterService
     */
    public function __construct($syncApiUrl, \Ps_eventbus $module, PsAccountsAdapterService $psAccountsAdapterService)
    {
        $this->module = $module;
        $this->jwt = $psAccountsAdapterService->getOrRefreshToken();
        $this->syncApiUrl = $syncApiUrl;
    }

    /**
     * @param string $jobId
     *
     * @return array<mixed>|bool
     */
    public function validateJobId($jobId)
    {
        $client = new HttpClientFactory(3);

        $response = $client->sendRequest(
            'GET',
            $this->syncApiUrl . '/job/' . $jobId,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->jwt,
                'User-Agent' => 'ps-eventbus/' . $this->module->version,
            ]
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
        ];
    }
}
