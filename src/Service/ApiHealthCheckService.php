<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsAccounts\Api\Client\AccountsClient;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ApiHealthCheckService
{
    /** @var \Db */
    private $db;

    /** @var PsAccountsAdapterService */
    private $psAccountsAdapterService;

    /** @var ApiAuthorizationService */
    private $apiAuthorizationService;

    /** @var array<mixed> */
    private $configuration;

    /** @var ErrorHandler */
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
     * @param PsAccountsAdapterService $psAccountsAdapterService
     * @param ErrorHandler $errorHandler
     * @param string $eventbusSyncApiUrl
     * @param string $eventbusLiveSyncApiUrl
     * @param string $eventbusProxyApiUrl
     *
     * @return void
     */
    public function __construct(
        PsAccountsAdapterService $psAccountsAdapterService,
        ApiAuthorizationService $apiAuthorizationService,
        ErrorHandler $errorHandler,
        $eventbusSyncApiUrl,
        $eventbusLiveSyncApiUrl,
        $eventbusProxyApiUrl
    ) {
        $this->db = \Db::getInstance();
        $this->apiAuthorizationService = $apiAuthorizationService;
        $this->psAccountsAdapterService = $psAccountsAdapterService;
        $this->configuration = [
            'EVENT_BUS_SYNC_API_URL' => $eventbusSyncApiUrl,
            'EVENT_BUS_LIVE_SYNC_API_URL' => $eventbusLiveSyncApiUrl,
            'EVENT_BUS_PROXY_API_URL' => $eventbusProxyApiUrl,
        ];
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $jobId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     */
    public function getHealthCheck($jobId)
    {
        $tokenValid = false;
        $tokenIsSet = false;
        $allTablesInstalled = false;

        $isAuthentified = $this->apiAuthorizationService->authorize($jobId, true);

        try {
            $token = $this->psAccountsAdapterService->getOrRefreshToken();
            if ($token) {
                $psAccount = \Module::getInstanceByName('ps_accounts');

                /* @phpstan-ignore-next-line */
                $accountsClient = $psAccount->getService(AccountsClient::class);

                $tokenIsSet = true;

                /** @phpstan-ignore-next-line */
                $response = $accountsClient->verifyToken($token);
                if ($response && true === $response['status']) {
                    $tokenValid = true;
                }
            }
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception);
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

        $psEventbus = \Module::getInstanceByName('ps_eventbus');

        if ($psEventbus == false) {
            throw new \Exception('ps_eventbus module is not installed');
        }

        $sensibleInformation = [
            'prestashop_version' => _PS_VERSION_,
            'ps_eventbus_version' => $psEventbus->version,
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
            return substr($item, strlen(_DB_PREFIX_));
        }, $requiredTables);

        // return array<string>, with list of missing required table
        return array_diff(self::REQUIRED_TABLES, $filteredRequiredTables);
    }
}
