<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;

class HealthCheckService
{
    /** @var \Ps_eventbus */
    private $module;

    /** @var \Db */
    private $db;

    /** @var PsAccountsAdapterService */
    private $psAccountsAdapterService;

    /** @var array<mixed> */
    private $configuration;

    /** @var ErrorHandlerInterface */
    private $errorHandler;

    /**
     * @var array<mixed>
     */
    const REQUIRED_TABLES = [
        'eventbus_type_sync',
        'eventbus_job',
        'eventbus_incremental_sync',
    ];

    /**
     * @param \Ps_eventbus $module
     * @param PsAccountsAdapterService $psAccountsAdapterService
     * @param ErrorHandlerInterface $errorHandler
     * @param string $eventbusSyncApiUrl
     * @param string $eventbusLiveSyncApiUrl
     * @param string $eventbusProxyApiUrl
     *
     * @return void
     */
    public function __construct(
        \Ps_eventbus $module,
        PsAccountsAdapterService $psAccountsAdapterService,
        ErrorHandlerInterface $errorHandler,
        $eventbusSyncApiUrl,
        $eventbusLiveSyncApiUrl,
        $eventbusProxyApiUrl
    ) {
        $this->module = $module;
        $this->db = \Db::getInstance();
        $this->psAccountsAdapterService = $psAccountsAdapterService;
        $this->configuration = [
            'EVENT_BUS_SYNC_API_URL' => $eventbusSyncApiUrl,
            'EVENT_BUS_LIVE_SYNC_API_URL' => $eventbusLiveSyncApiUrl,
            'EVENT_BUS_PROXY_API_URL' => $eventbusProxyApiUrl,
        ];
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param bool $isAuthentified
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     */
    public function getHealthCheck($isAuthentified)
    {
        $tokenValid = false;
        $tokenIsSet = false;
        $allTablesInstalled = false;

        try {
            $token = $this->psAccountsAdapterService->getOrRefreshToken();
            if ($token) {
                $accountsClient = $this->module->getService('PrestaShop\Module\PsAccounts\Api\Client\AccountsClient');

                $tokenIsSet = true;

                /** @phpstan-ignore-next-line */
                $response = $accountsClient->verifyToken($token);
                if ($response && true === $response['status']) {
                    $tokenValid = true;
                }
            }
        } catch (\Exception $e) {
            $this->errorHandler->handle($e);
            $tokenIsSet = false;
        }

        $missingTables = $this->getMissingRequiredTables();

        if (count($missingTables) == 0) {
            $allTablesInstalled = true;
        }

        if (defined('PHP_VERSION') && defined('PHP_EXTRA_VERSION')) {
            $phpVersion = str_replace(PHP_EXTRA_VERSION, '', PHP_VERSION);
        } else {
            $phpVersion = (string) explode('-', (string) phpversion())[0];
        }

        $sensibleInformation = [
            'prestashop_version' => _PS_VERSION_,
            'ps_eventbus_version' => \Ps_eventbus::VERSION,
            'ps_accounts_version' => defined('Ps_accounts::VERSION') ? \Ps_accounts::VERSION : false, /* @phpstan-ignore-line */
            'php_version' => $phpVersion,
            'shop_id' => $this->psAccountsAdapterService->getShopUuid(),
        ];

        $serverInformation = [
            'ps_account' => $tokenIsSet,
            'is_valid_jwt' => $tokenValid,
            'ps_eventbus' => $allTablesInstalled,
            'env' => [
                'EVENT_BUS_PROXY_API_URL' => isset($this->configuration['EVENT_BUS_PROXY_API_URL']) ? $this->configuration['EVENT_BUS_PROXY_API_URL'] : null,
                'EVENT_BUS_SYNC_API_URL' => isset($this->configuration['EVENT_BUS_SYNC_API_URL']) ? $this->configuration['EVENT_BUS_SYNC_API_URL'] : null,
                'EVENT_BUS_LIVE_SYNC_API_URL' => isset($this->configuration['EVENT_BUS_LIVE_SYNC_API_URL']) ? $this->configuration['EVENT_BUS_LIVE_SYNC_API_URL'] : null,
            ],
        ];

        if ($isAuthentified) {
            $serverInformation = array_merge($sensibleInformation, $serverInformation);
        }

        return $serverInformation;
    }

    /**
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    private function getMissingRequiredTables()
    {
        $requiredTablesQuery = 'SELECT TABLE_NAME FROM information_schema.tables WHERE table_name LIKE \'%eventbus%\';';
        $requiredTablesResponse = (array) $this->db->executeS($requiredTablesQuery);

        // Transform 2D array into array<string>
        $requiredTables = array_column($requiredTablesResponse, 'TABLE_NAME');

        // Remove the prefix of the tables (ex: ps_)
        $filteredRequiredTables = array_map(function ($item) {
            return substr($item, strpos($item, '_') + 1);
        }, $requiredTables);

        // return array<string>, with list of missing required table
        return array_diff(self::REQUIRED_TABLES, $filteredRequiredTables);
    }
}
