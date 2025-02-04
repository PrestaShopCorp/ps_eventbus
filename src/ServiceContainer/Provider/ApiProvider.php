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

use PrestaShop\Module\PsEventbus\Api\CloudSyncClient;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use PrestaShop\Module\PsEventbus\ServiceContainer\Contract\IServiceProvider;
use PrestaShop\Module\PsEventbus\ServiceContainer\ServiceContainer;

class ApiProvider implements IServiceProvider
{
    /**
     * @param ServiceContainer $container
     *
     * @return void
     */
    public function provide(ServiceContainer $container)
    {
        $container->registerProvider(CloudSyncClient::class, static function () use ($container) {
            return new CloudSyncClient(
                $container->getParameter('ps_eventbus.proxy_api_url'),
                $container->getParameter('ps_eventbus.live_sync_api_url'),
                $container->getParameter('ps_eventbus.sync_api_url'),
                $container->get('ps_eventbus.module'),
                $container->get(PsAccountsAdapterService::class)
            );
        });
    }
}
