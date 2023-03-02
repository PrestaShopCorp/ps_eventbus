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
     * @param string $syncApiUrl
     * @param \Ps_eventbus $module
     */
    public function __construct(PsAccounts $psAccounts, $syncApiUrl, $module)
    {
        $this->module = $module;
        $this->jwt = $psAccounts->getPsAccountsService()->getOrRefreshToken();

        // @see https://docs.guzzlephp.org/en/stable/quickstart.html
        $this->client = (new ClientFactory())->getClient([
            'allow_redirects' => true,
            'base_uri' => $syncApiUrl,
            'connect_timeout' => 3,
            'http_errors' => false,
        ]);
    }

    /**
     * @param string $jobId
     *
     * @return array|bool
     */
    public function validateJobId($jobId)
    {
        $rawResponse = $this->client->sendRequest(
            new Request(
                'GET',
                '/job/' . $jobId,
                [
                    'timeout' => Config::SYNC_API_MAX_TIMEOUT,
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer $this->jwt",
                        'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    ],
                ]
            )
        );

        return [
            'status' => substr((string) $rawResponse->getStatusCode(), 0, 1) === '2',
            'httpCode' => $rawResponse->getStatusCode(),
        ];
    }
}
