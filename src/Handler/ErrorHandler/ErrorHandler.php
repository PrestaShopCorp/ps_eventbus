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

use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

/**
 * Handle Error.
 */
class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @var ?\Raven_Client
     */
    protected $client;

    public function __construct(\Module $module, PsAccounts $accountsService, string $sentryDsn, string $sentryEnv)
    {
        $psAccounts = \Module::getInstanceByName('ps_accounts');
        try {
            $this->client = new \Raven_Client(
                $sentryDsn,
                [
                    'level' => 'warning',
                    'tags' => [
                        'shop_id' => $accountsService->getPsAccountsService()->getShopUuid(),
                        'ps_eventbus_version' => $module->version,
                        'ps_accounts_version' => $psAccounts ? $psAccounts->version : false,
                        'php_version' => phpversion(),
                        'prestashop_version' => _PS_VERSION_,
                        'ps_eventbus_is_enabled' => \Module::isEnabled($module->name),
                        'ps_eventbus_is_installed' => \Module::isInstalled($module->name),
                        'env' => $sentryEnv,
                    ],
                ]
            );
            /** @var string $configurationPsShopEmail */
            $configurationPsShopEmail = \Configuration::get('PS_SHOP_EMAIL');
            $this->client->set_user_data($accountsService->getPsAccountsService()->getShopUuid(), $configurationPsShopEmail);
        } catch (\Exception $e) {
        }
    }

    /**
     * @param \Exception $error
     * @param mixed $code
     * @param bool|null $throw
     * @param array|null $data
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle($error, $code = null, $throw = true, $data = null)
    {
        if (!$this->client) {
            return;
        }
        $this->client->captureException($error, $data);
        if (is_int($code) && true === $throw) {
            http_response_code($code);
            throw $error;
        }
    }

    /**
     * @return void
     */
    private function __clone()
    {
    }
}
