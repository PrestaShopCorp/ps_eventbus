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

namespace PrestaShop\Module\PsEventbus\Handler\ErrorHandler;

use PrestaShop\Module\PsEventbus\Service\CommonService;

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
     * @param string $sentryDsn
     * @param string $sentryEnv
     *
     * @return void
     */
    public function __construct($sentryDsn, $sentryEnv)
    {
        try {
            /** @var \ModuleCore $accountsModule */
            $accountsModule = \Module::getInstanceByName('ps_accounts');
            /** @var mixed $accountService */
            $accountService = $accountsModule->get('PrestaShop\Module\PsAccounts\Service\PsAccountsService');

            /** @var \ModuleCore $eventbusModule */
            $eventbusModule = \Module::getInstanceByName('ps_eventbus');
        } catch (\Exception $e) {
            $accountsModule = null;
            $accountService = null;
            $eventbusModule = null;
        }

        try {
            $this->client = new \Raven_Client(
                $sentryDsn,
                [
                    'level' => 'warning',
                    'tags' => [
                        'shop_id' => $accountService ? $accountService->getShopUuid() : false,
                        'ps_eventbus_version' => $eventbusModule ? $eventbusModule->version : false,
                        'ps_accounts_version' => $accountsModule ? $accountsModule->version : false,
                        'php_version' => phpversion(),
                        'prestashop_version' => _PS_VERSION_,
                        'ps_eventbus_is_enabled' => $eventbusModule ? \Module::isEnabled((string) $eventbusModule->name) : false,
                        'ps_eventbus_is_installed' => $eventbusModule ? \Module::isInstalled((string) $eventbusModule->name) : false,
                        'env' => $sentryEnv,
                    ],
                ]
            );
            /** @var string $configurationPsShopEmail */
            $configurationPsShopEmail = \Configuration::get('PS_SHOP_EMAIL');
            $this->client->set_user_data(
                $accountService ? $accountService->getShopUuid() : false,
                $configurationPsShopEmail
            );
        } catch (\Exception $e) {
        }
    }

    /**
     * @param mixed $exception
     * @param mixed $silent
     *
     * @return void
     *
     * @@throws Exception
     */
    public function handle($exception, $silent = null)
    {
        $logsEnabled = false;
        $verboseEnabled = false;

        if (!$this->client) {
            return;
        }

        if (defined('PS_EVENTBUS_VERBOSE_ENABLED')) {
            $logsEnabled = PS_EVENTBUS_VERBOSE_ENABLED;
        }

        if (defined('PS_EVENTBUS_VERBOSE_ENABLED')) {
            $verboseEnabled = PS_EVENTBUS_VERBOSE_ENABLED;
        }

        if ($logsEnabled) {
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
        if (_PS_MODE_DEV_ && $verboseEnabled) {
            throw $exception;
        } else {
            $this->client->captureException($exception);

            if ($silent) {
                return;
            }

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
