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
use PrestaShop\Module\PsAccounts\Service\OAuth2\Token\Validator\Validator;
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
     * Fallback lower bound, used only when ps_versions_compliancy cannot be
     * read off the module instance.
     */
    const MIN_PRESTASHOP_VERSION = '1.6.1.11';

    /**
     * Mirrors ps_eventbus::isPhpVersionCompliant(), which gates the autoloader.
     */
    const MIN_PHP_VERSION = '5.6.0';

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
            $token = $this->psAccountsAdapterService->getShopToken();
            if ($token) {
                $psAccount = \Module::getInstanceByName('ps_accounts');
                $tokenIsSet = true;
                $tokenValid = $this->verifyShopToken($psAccount, $token);
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
     * Health check for the module configuration page.
     *
     * Unlike getHealthCheck(), this is not the contract CloudSync probes: there
     * is no job authorization involved, and it exposes what the dashboard needs
     * to render its checks. Everything here is observable from inside the shop.
     * The checks that require an outside view (does CloudSync reach us at all,
     * is a WAF in the way) cannot be answered here.
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getDashboardHealthCheck()
    {
        $psAccountsModule = $this->psAccountsAdapterService->getModule();
        $psEventbusModule = \Module::getInstanceByName('ps_eventbus');

        $tokenIsSet = false;

        try {
            $tokenIsSet = (bool) $this->psAccountsAdapterService->getShopToken();
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception);
        }

        $psAccountsUpdate = $this->getModuleUpdateState('ps_accounts', $psAccountsModule ? $psAccountsModule->version : null);
        $psEventbusUpdate = $this->getModuleUpdateState('ps_eventbus', $psEventbusModule ? $psEventbusModule->version : null);

        return [
            'psAccount' => [
                'installed' => (bool) $psAccountsModule,
                'linked' => $tokenIsSet,
                'version' => $psAccountsModule ? $psAccountsModule->version : null,
                'latestVersion' => $psAccountsUpdate['latestVersion'],
                'upToDate' => $psAccountsUpdate['upToDate'],
            ],
            'psEventbus' => [
                'tablesInstalled' => count($this->getMissingRequiredTables()) === 0,
                'version' => $psEventbusModule ? $psEventbusModule->version : null,
                'latestVersion' => $psEventbusUpdate['latestVersion'],
                'upToDate' => $psEventbusUpdate['upToDate'],
            ],
            'compatibility' => $this->getCompatibility($psEventbusModule),
            'accountsShopUrl' => $this->psAccountsAdapterService->getShopUrl(),
        ];
    }

    /**
     * PHP and PrestaShop versions checked against what ps_eventbus declares it
     * supports, rather than against hardcoded values.
     *
     * @param \ModuleCore|false $psEventbusModule
     *
     * @return array<mixed>
     */
    private function getCompatibility($psEventbusModule)
    {
        $minPrestashopVersion = self::MIN_PRESTASHOP_VERSION;

        if ($psEventbusModule && !empty($psEventbusModule->ps_versions_compliancy['min'])) {
            $minPrestashopVersion = (string) $psEventbusModule->ps_versions_compliancy['min'];
        }

        $phpVersion = $this->getPhpVersion();
        $phpCompatible = version_compare($phpVersion, self::MIN_PHP_VERSION, '>=');
        $prestashopCompatible = version_compare(_PS_VERSION_, $minPrestashopVersion, '>=');

        return [
            'phpVersion' => $phpVersion,
            'minPhpVersion' => self::MIN_PHP_VERSION,
            'phpCompatible' => $phpCompatible,
            'prestashopVersion' => _PS_VERSION_,
            'minPrestashopVersion' => $minPrestashopVersion,
            'prestashopCompatible' => $prestashopCompatible,
            'compatible' => $phpCompatible && $prestashopCompatible,
        ];
    }

    /**
     * The PHP version without its distribution suffix (ex: 8.1.2 instead of
     * 8.1.2-1ubuntu2.14).
     *
     * @return string
     */
    private function getPhpVersion()
    {
        if (defined('PHP_VERSION') && defined('PHP_EXTRA_VERSION') && PHP_EXTRA_VERSION !== '') {
            return str_replace(PHP_EXTRA_VERSION, '', PHP_VERSION);
        }

        return (string) explode('-', (string) phpversion())[0];
    }

    /**
     * Whether a module is behind its latest published version.
     *
     * Delegated to the core module repository rather than queried ourselves, so
     * that the dashboard reports exactly what the merchant already sees in the
     * Module Manager, over whichever distribution channel the shop uses, with
     * no extra HTTP call of our own.
     *
     * The repository only exists from PrestaShop 1.7 on and needs a booted
     * Symfony container, so every failure mode degrades to "unknown" rather
     * than to a false claim that the module is current.
     *
     * @param string $moduleName
     * @param string|null $installedVersion
     *
     * @return array{latestVersion: string|null, upToDate: bool|null}
     */
    private function getModuleUpdateState($moduleName, $installedVersion)
    {
        $unknown = ['latestVersion' => null, 'upToDate' => null];

        if (empty($installedVersion) || !class_exists('PrestaShop\PrestaShop\Adapter\SymfonyContainer')) {
            return $unknown;
        }

        try {
            $container = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance();

            if ($container === null || !$container->has('PrestaShop\PrestaShop\Core\Module\ModuleRepository')) {
                return $unknown;
            }

            $repo = $container->get('PrestaShop\PrestaShop\Core\Module\ModuleRepository');

            if (!is_object($repo) || !method_exists($repo, 'getModule')) {
                return $unknown;
            }

            $module = $repo->getModule($moduleName);

            if (!is_object($module) || !isset($module->attributes) || !method_exists($module->attributes, 'get')) {
                return $unknown;
            }

            /** @var string|null $latestVersion */
            $latestVersion = $module->attributes->get('version_available');

            if (empty($latestVersion)) {
                // No published version known: canBeUpgraded() would compare
                // against the version on disk and always answer false.
                return $unknown;
            }

            return [
                'latestVersion' => (string) $latestVersion,
                'upToDate' => version_compare($installedVersion, (string) $latestVersion, '>='),
            ];
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception, true);

            return $unknown;
        }
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

    /**
     * Verify a shop token. ps_accounts v8+ emits hydra tokens validated locally
     * via JWKS (Validator). Older versions emit firebase tokens validated via
     * the legacy /v1/shop/token/verify endpoint (AccountsClient, deprecated v8).
     *
     * @param \ModuleCore|false $psAccount
     * @param string $token
     *
     * @return bool
     */
    private function verifyShopToken($psAccount, $token)
    {
        if (!$psAccount) {
            return false;
        }

        $isV8 = version_compare($psAccount->version, '8.0.0', '>=');
        /** @phpstan-ignore-next-line */
        $serviceClass = $isV8 ? Validator::class : AccountsClient::class;

        try {
            /** @phpstan-ignore-next-line */
            $service = $psAccount->getService($serviceClass);
            /** @phpstan-ignore-next-line */
            $response = $service->verifyToken($token);

            return $isV8 || ($response && true === $response['status']);
        } catch (\Exception $e) {
            $this->errorHandler->handle($e, true);

            return false;
        }
    }
}
