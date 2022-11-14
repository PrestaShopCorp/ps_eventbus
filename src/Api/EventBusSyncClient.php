<?php

namespace PrestaShop\Module\PsEventbus\Api;

use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
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
     * @param \Link $link
     * @param PsAccounts $psAccounts
     * @param string $baseUrl
     *
     * @throws \PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleNotInstalledException
     * @throws \PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleVersionException
     * @throws \Exception
     */
    public function __construct(\Link $link, PsAccounts $psAccounts, $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->setLink($link);
        $token = $psAccounts->getPsAccountsService()->getOrRefreshToken();
        $options = [
            'base_uri' => $this->baseUrl,
            'timeout' => 60,
            'http_errors' => $this->catchExceptions,
            'headers' => [
                'authorization' => "Bearer $token",
                'Accept' => 'application/json',
            ],
        ];

        $client = (new ClientFactory())->getClient($options);

        parent::__construct($client, $options);
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
