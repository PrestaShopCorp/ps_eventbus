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

use Configuration;
use Module;
use PrestaShop\Module\PsEventbus\Config\Env;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;
use Raven_Client;

/**
 * Handle Error.
 */
class ErrorHandler extends \PrestaShop\Sentry\Handler\ErrorHandler
{
    /**
     * @var ?Raven_Client
     */
    protected $client;

    public function __construct(Module $module, Env $env, PsAccounts $accountsService)
    {
        parent::__construct($env->get('SENTRY_CREDENTIALS'), $module->getLocalPath());

        $psAccounts = Module::getInstanceByName('ps_accounts');

        $this->setUser(
            [
                'id' => $accountsService->getPsAccountsService()->getShopUuid(),
                'name' => Configuration::get('PS_SHOP_EMAIL'),
            ],
            true
        );

        $this->setLevel(\Sentry\Severity::warning());

        $this->setModuleInfo($module);
        $this->setTags(
            [
                'shop_id' => $accountsService->getPsAccountsService()->getShopUuid(),
                'ps_accounts_version' => $psAccounts ? $psAccounts->version : false,
                'php_version' => phpversion(),
                'prestashop_version' => _PS_VERSION_,
                'env' => $env->get('SENTRY_ENVIRONMENT'),
            ]
        );
    }
}
