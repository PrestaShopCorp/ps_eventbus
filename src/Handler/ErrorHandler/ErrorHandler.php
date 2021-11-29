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

use Context;
use Module;
use Raven_Client;

/**
 * Handle Error.
 */
class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @var Raven_Client
     */
    protected $client;

    public function __construct(Module $module, Context $context, $sentryCredentials)
    {
        $psAccounts = Module::getInstanceByName('ps_accounts');
        $this->client = new Raven_Client(
            $sentryCredentials,
            [
                'level' => 'warning',
                'tags' => [
                    'shop_id' => $context->shop->id,
                    'ps_eventbus_version' => $module->version,
                    'ps_accounts_version' => $psAccounts ? $psAccounts->version : false,
                    'php_version' => phpversion(),
                    'prestashop_version' => _PS_VERSION_,
                    'ps_eventbus_is_enabled' => Module::isEnabled($module->name),
                    'ps_eventbus_is_installed' => Module::isInstalled($module->name),
                ],
            ]
        );
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
        $this->client->captureException($error, $data);
        if ($code && true === $throw) {
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
