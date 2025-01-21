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

namespace PrestaShop\Module\PsEventbus\ServiceContainer\Provider;

use PrestaShop\Module\PsEventbus\Api\CollectorApiClient;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Formatter\JsonFormatter;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;
use PrestaShop\Module\PsEventbus\Service\PresenterService;
use PrestaShop\Module\PsEventbus\Service\ProxyService;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use PrestaShop\Module\PsEventbus\ServiceContainer\Contract\IServiceProvider;
use PrestaShop\Module\PsEventbus\ServiceContainer\ServiceContainer;

class CommonProvider implements IServiceProvider
{
    /**
     * @param ServiceContainer $container
     *
     * @return void
     */
    public function provide(ServiceContainer $container)
    {
        $container->registerProvider('ps_eventbus.context', static function () {
            return \Context::getContext();
        });
        $container->registerProvider('ps_eventbus.module', static function () {
            return \Module::getInstanceByName('ps_eventbus');
        });
        $container->registerProvider(ModuleHelper::class, static function () {
            return new ModuleHelper();
        });
        $container->registerProvider(PsAccountsAdapterService::class, static function () use ($container) {
            return new PsAccountsAdapterService(
                $container->get(ModuleHelper::class),
                $container->get(ErrorHandler::class)
            );
        });
        $container->registerProvider(JsonFormatter::class, static function () {
            return new JsonFormatter();
        });
        $container->registerProvider(ArrayFormatter::class, static function () {
            return new ArrayFormatter();
        });
        $container->registerProvider(ProxyService::class, static function () use ($container) {
            return new ProxyService(
                $container->get(CollectorApiClient::class),
                $container->get(JsonFormatter::class),
                $container->get(ErrorHandler::class)
            );
        });
        $container->registerProvider(ErrorHandler::class, static function () use ($container) {
            return new ErrorHandler(
                $container->getParameter('ps_eventbus.sentry_dsn'),
                $container->getParameter('ps_eventbus.sentry_env')
            );
        });

        $container->registerProvider(PresenterService::class, static function () {
            return new PresenterService();
        });
    }
}
