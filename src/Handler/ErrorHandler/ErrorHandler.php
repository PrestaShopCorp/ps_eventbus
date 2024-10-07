<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Handler\ErrorHandler;

use Exception;
use PrestaShop\Module\PsEventbus\Service\CommonService;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Handle Error.
 */
class ErrorHandler
{
    /**
     * @var ?\Raven_Client
     */
    protected $client;

    /**
     * @param \Ps_eventbus $module
     * @param PsAccountsAdapterService $psAccountsAdapterService
     * @param string $sentryDsn
     * @param string $sentryEnv
     *
     * @return void
     */
    public function __construct(\Ps_eventbus $module, PsAccountsAdapterService $psAccountsAdapterService, $sentryDsn, $sentryEnv)
    {
        try {
            $this->client = new \Raven_Client(
                $sentryDsn,
                [
                    'level' => 'warning',
                    'tags' => [
                        'shop_id' => $psAccountsAdapterService->getShopUuid(),
                        'ps_eventbus_version' => $module->version,
                        'ps_accounts_version' => $psAccountsAdapterService->getModule() ? $psAccountsAdapterService->getModule()->version : false,
                        'php_version' => phpversion(),
                        'prestashop_version' => _PS_VERSION_,
                        'ps_eventbus_is_enabled' => \Module::isEnabled((string) $module->name),
                        'ps_eventbus_is_installed' => \Module::isInstalled((string) $module->name),
                        'env' => $sentryEnv,
                    ],
                ]
            );
            /** @var string $configurationPsShopEmail */
            $configurationPsShopEmail = \Configuration::get('PS_SHOP_EMAIL');
            $this->client->set_user_data($psAccountsAdapterService->getShopUuid(), $configurationPsShopEmail);
        } catch (\Exception $e) {
        }
    }

    /**
     * @param mixed $exception
     *
     * @return void
     *
     * @@throws Exception
     */
    public function handle($exception)
    {
        if (!$this->client) {
            return;
        }

        if (PS_EVENTBUS_LOGS_ENABLED) {
            \PrestaShopLogger::addLog(
                $exception->getMessage() . ' : ' . $exception->getFile() . ':' . $exception->getLine() . ' | ' . $exception->getTraceAsString(),
                3,
                $exception->getCode() > 0 ? $exception->getCode() : 500,
                'Module',
                \Module::getModuleIdByName('ps_eventbus'),
                true
            );
        }

        // if debug mode enabled and verbose set to true, print error in front office
        if (_PS_MODE_DEV_ == true && PS_EVENTBUS_VERBOSE_ENABLED == true) {
            throw $exception;
        } else {
            $this->client->captureException($exception);
            CommonService::exitWithExceptionMessage($exception);
        }
    }

    /**
     * @return void
     */
    private function __clone()
    {
    }
}
