<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Client;
use Link;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

class EventBusSyncClient extends GenericClient
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * EventBusSyncClient constructor.
     *
     * @param Link $link
     * @param PsAccounts $psAccountsService
     * @param string $baseUrl
     *
     * @throws \PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleNotInstalledException
     * @throws \PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleVersionException
     */
    public function __construct(Link $link, PsAccounts $psAccountsService, $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->setLink($link);
        $token = $psAccountsService->getPsAccountsService()->getOrRefreshToken();

        $client = new Client([
            'base_url' => $this->baseUrl,
            'defaults' => [
                'timeout' => $this->timeout,
                'exceptions' => $this->catchExceptions,
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $token",
                ],
            ],
        ]);

        parent::__construct($client);
    }

    /**
     * @param string $jobId
     *
     * @return array|bool
     *
     * @throws EnvVarException
     */
    public function validateJobId($jobId)
    {
        $this->setRoute($this->baseUrl . "/job/$jobId");

        return $this->get();
    }
}
