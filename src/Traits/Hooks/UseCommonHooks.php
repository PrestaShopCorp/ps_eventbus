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

namespace PrestaShop\Module\PsEventbus\Traits\Hooks;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;

if (!defined('_PS_VERSION_')) {
    exit;
}

trait UseCommonHooks
{
    /**
     * This is global hook. This hook is called at the beginning of the dispatch method of the Dispatcher
     * It's possible to use this hook all time when we don't have specific hook.
     * Available since: 1.7.1
     *
     * Unable to use hookActionDispatcherAfter. Seem to be have a strange effect. When i use
     * this hook and try to dump() the content, no dump appears in the symfony debugger, and no more hooks appear.
     * For security reasons, I like to use the before hook, and put it in a try/catch
     *
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionDispatcherBefore($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        try {
            /*
             * Class "ActionDispatcherLegacyHooksSubscriber" as implement in 1.7.3.0:
             * https://github.com/PrestaShop/PrestaShop/commit/a4ae4544cc62c818aba8b3d9254308f538b7acdc
             */
            if ($parameters['controller_type'] != 2) {
                return;
            }

            if (array_key_exists('route', $parameters)) {
                $route = $parameters['route'];

                // when translation is edited or reset, add to incremental sync
                if ($route == 'api_translation_value_edit' || $route == 'api_translation_value_reset') {
                    $synchronizationService->insertContentIntoIncremental(
                        [Config::COLLECTION_TRANSLATIONS => 0],
                        Config::INCREMENTAL_TYPE_UPSERT,
                        date(DATE_ATOM),
                        $this->shopId,
                        false
                    );
                }
            }
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * @return void
     */
    public function hookActionShippingPreferencesPageSave()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->sendLiveSync(Config::COLLECTION_CARRIERS, Config::INCREMENTAL_TYPE_UPSERT);
        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }
}
