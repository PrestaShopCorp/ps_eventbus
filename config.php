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

return [
    'ps_eventbus.proxy_api_url' => 'http://reverse-proxy/collector',
    'ps_eventbus.sync_api_url' => 'http://reverse-proxy/sync-api',
    'ps_eventbus.live_sync_api_url' => 'http://reverse-proxy/live-sync-api/v1',
    'ps_eventbus.sentry_dsn' => 'https://sentry-id@stuff.ingest.sentry.io/stuff',
    'ps_eventbus.sentry_env' => 'development',
];
