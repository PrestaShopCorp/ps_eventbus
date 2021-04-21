<?php

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Client;
use Link;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

class EventBusSyncClient extends GenericClient
{
    public function __construct(Link $link, PsAccounts $psAccountsService)
    {
        $this->setLink($link);
        $token = $psAccountsService->getPsAccountsService()->getOrRefreshToken();

        $client = new Client([
            'base_url' => $_ENV['EVENT_BUS_SYNC_API_URL'],
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
        if (!isset($_ENV['EVENT_BUS_SYNC_API_URL'])) {
            throw new EnvVarException('EVENT_BUS_SYNC_API_URL is not defined');
        }

        $this->setRoute($_ENV['EVENT_BUS_SYNC_API_URL'] . "/job/$jobId");

        return $this->get();
    }
}
