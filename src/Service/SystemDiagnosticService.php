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

use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;
use PrestaShop\Module\PsEventbus\Helper\NetworkProbe;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * The shop's vital signs, as displayed on the Support & debug page and copied
 * into a support ticket.
 *
 * This is not the contract CloudSync probes — that one lives in
 * ApiHealthCheckService::getHealthCheck() and hides everything sensitive behind
 * a job authorization. Here the caller is an authenticated back-office
 * employee, so the full picture can be handed over.
 *
 * Nothing in here throws on a failing probe. A diagnostic that reports "could
 * not determine" for one line is still worth sending to the support team; one
 * that returns an error page is not.
 */
class SystemDiagnosticService
{
    /**
     * Modules reported, in the order the page displays them.
     *
     * The required ones are always listed, with a null version when absent —
     * "PS Accounts is missing" is itself a diagnostic. The optional ones are
     * omitted entirely when not installed, since a shop that never subscribed
     * to a partner service has nothing to answer for.
     *
     * Labels are product names rather than the modules' own displayName: the
     * latter varies between versions and distributions, which makes two
     * diagnostics harder to compare.
     *
     * @var array<string, array{label: string, required: bool}>
     */
    const MODULES = [
        'ps_eventbus' => ['label' => 'PS EventBus', 'required' => true],
        'ps_accounts' => ['label' => 'PS Accounts', 'required' => true],
        'psmarketingwithgoogle' => ['label' => 'PS Marketing with Google', 'required' => false],
        'ps_facebook' => ['label' => 'PS Social with Facebook', 'required' => false],
        'ps_metrics' => ['label' => 'PS Metrics', 'required' => false],
    ];

    /** @var PsAccountsAdapterService */
    private $psAccountsAdapterService;

    /** @var ModuleHelper */
    private $moduleHelper;

    /** @var NetworkProbe */
    private $networkProbe;

    /** @var ErrorHandler */
    private $errorHandler;

    /** @var array<string, string> */
    private $env;

    /**
     * CloudSync endpoint pinged to prove the shop can reach the outside.
     *
     * @var string
     */
    private $cloudApiUrl;

    /** @var string */
    private $shopDomain;

    /** @var bool */
    private $sslEnabled;

    /**
     * @param PsAccountsAdapterService $psAccountsAdapterService
     * @param ModuleHelper $moduleHelper
     * @param NetworkProbe $networkProbe
     * @param ErrorHandler $errorHandler
     * @param string $eventbusProxyApiUrl
     * @param string $eventbusSyncApiUrl
     * @param string $eventbusLiveSyncApiUrl
     * @param string $cloudApiUrl
     * @param string $shopDomain
     * @param bool $sslEnabled
     */
    public function __construct(
        PsAccountsAdapterService $psAccountsAdapterService,
        ModuleHelper $moduleHelper,
        NetworkProbe $networkProbe,
        ErrorHandler $errorHandler,
        $eventbusProxyApiUrl,
        $eventbusSyncApiUrl,
        $eventbusLiveSyncApiUrl,
        $cloudApiUrl,
        $shopDomain,
        $sslEnabled
    ) {
        $this->psAccountsAdapterService = $psAccountsAdapterService;
        $this->moduleHelper = $moduleHelper;
        $this->networkProbe = $networkProbe;
        $this->errorHandler = $errorHandler;
        $this->env = [
            'EVENT_BUS_PROXY_API_URL' => (string) $eventbusProxyApiUrl,
            'EVENT_BUS_SYNC_API_URL' => (string) $eventbusSyncApiUrl,
            'EVENT_BUS_LIVE_SYNC_API_URL' => (string) $eventbusLiveSyncApiUrl,
        ];
        $this->cloudApiUrl = (string) $cloudApiUrl;
        $this->shopDomain = (string) $shopDomain;
        $this->sslEnabled = (bool) $sslEnabled;
    }

    /**
     * @return array<string, mixed>
     */
    public function getDiagnostic()
    {
        $phpVersion = $this->getPhpVersion();

        return [
            'prestashopVersion' => _PS_VERSION_,
            'phpVersion' => $phpVersion,
            'minPhpVersion' => ApiHealthCheckService::MIN_PHP_VERSION,
            'phpCompatible' => version_compare($phpVersion, ApiHealthCheckService::MIN_PHP_VERSION, '>='),
            'modules' => $this->getModules(),
            'cloudApi' => array_merge(['url' => $this->cloudApiUrl], $this->networkProbe->ping($this->cloudApiUrl)),
            'env' => $this->env,
            'ssl' => $this->getSslState(),
            'shopDomain' => $this->shopDomain,
            'accountsShopUrl' => $this->getAccountsShopUrl(),
            'shopId' => $this->getShopId(),
            'generatedAt' => date('c'),
        ];
    }

    /**
     * @return array<int, array{id: string, label: string, version: string|null}>
     */
    private function getModules()
    {
        $modules = [];

        foreach (self::MODULES as $moduleName => $definition) {
            $version = $this->getModuleVersion($moduleName);

            if ($version === null && !$definition['required']) {
                continue;
            }

            $modules[] = [
                'id' => $moduleName,
                'label' => $definition['label'],
                'version' => $version,
            ];
        }

        return $modules;
    }

    /**
     * The installed version, or null when the module is not installed on this
     * shop. A module present on disk but never installed counts as absent.
     *
     * @param string $moduleName
     *
     * @return string|null
     */
    private function getModuleVersion($moduleName)
    {
        try {
            if (!$this->moduleHelper->isInstalled($moduleName)) {
                return null;
            }

            $module = $this->moduleHelper->getInstanceByName($moduleName);

            if (!$module || empty($module->version)) {
                return null;
            }

            return (string) $module->version;
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception, true);

            return null;
        }
    }

    /**
     * State of the shop's HTTPS setup.
     *
     * A shop not configured for SSL is not a certificate problem, so no
     * certificate is inspected in that case: `https` false already says what
     * needs fixing.
     *
     * @return array{https: bool, valid: bool|null, expiresAt: string|null, error: string|null}
     */
    private function getSslState()
    {
        if (!$this->sslEnabled) {
            return ['https' => false, 'valid' => null, 'expiresAt' => null, 'error' => null];
        }

        return array_merge(['https' => true], $this->networkProbe->inspectCertificate($this->shopDomain));
    }

    /**
     * @return string|null
     */
    private function getAccountsShopUrl()
    {
        try {
            return $this->psAccountsAdapterService->getShopUrl();
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception, true);

            return null;
        }
    }

    /**
     * @return string|null
     */
    private function getShopId()
    {
        try {
            // ps_accounts answers false rather than an empty string on an
            // unlinked shop, whatever the adapter's annotation claims.
            $uuid = $this->psAccountsAdapterService->getShopUuid();

            return empty($uuid) ? null : (string) $uuid;
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception, true);

            return null;
        }
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
}
