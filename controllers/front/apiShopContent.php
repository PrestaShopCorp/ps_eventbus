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

use PrestaShop\Module\PsEventbus\Service\ApiShopContentService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ps_EventbusApiShopContentModuleFrontController extends ModuleFrontController
{
    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var string $shopContent */
        $shopContent = Tools::getValue('shop_content');

        /** @var string $jobId */
        $jobId = Tools::getValue('job_id');

        /** @var string $langIso */
        $langIso = Tools::getValue('lang_iso');

        /** @var int $limit */
        $limit = Tools::getValue('limit', 50);

        /** @var bool $fullSyncRequested */
        $fullSyncRequested = Tools::getValue('full', 0) == 1;

        /** @var bool $explainSql */
        $explainSql = Tools::getValue('explain_sql', 0) == 1;

        /** @var bool $verbose */
        $verbose = Tools::getValue('verbose', 0) == 1;

        /** @var bool $psLogsEnabled */
        $psLogsEnabled = Tools::getValue('ps_logs_enabled', 0) == 1;

        /** @var Ps_eventbus $module */
        $module = Module::getInstanceByName('ps_eventbus');

        /** @var ApiShopContentService $apiShopContentService */
        $apiShopContentService = $module->getService(ApiShopContentService::class);

        // Define our 3 constants here to be retrieved later in the application (errorHandler, repositories)
        if (!defined('PS_EVENTBUS_EXPLAIN_SQL_ENABLED')) {
            define('PS_EVENTBUS_EXPLAIN_SQL_ENABLED', $explainSql);
        }

        if (!defined('PS_EVENTBUS_VERBOSE_ENABLED')) {
            define('PS_EVENTBUS_VERBOSE_ENABLED', $verbose);
        }

        if (!defined('PS_EVENTBUS_LOGS_ENABLED')) {
            define('PS_EVENTBUS_LOGS_ENABLED', $psLogsEnabled);
        }

        if (!defined('REQUEST_START_TIME')) {
            define('REQUEST_START_TIME', microtime(true));
        }

        // edit shopContent for matching Config.php const
        $shopContentEdited = str_replace('-', '_', $shopContent);

        $apiShopContentService->handleDataSync(
            $shopContentEdited,
            $jobId,
            $langIso,
            $limit,
            $fullSyncRequested
        );
    }
}
