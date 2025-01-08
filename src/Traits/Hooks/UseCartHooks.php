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

trait UseCartHooks
{
    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCartAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_CARTS,
                    Config::COLLECTION_CART_PRODUCTS,
                ],
                Config::INCREMENTAL_TYPE_UPSERT
            );

            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_CARTS => $cart->id,
                    Config::COLLECTION_CART_PRODUCTS => $cart->id,
                ],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCartUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_CARTS,
                    Config::COLLECTION_CART_PRODUCTS,
                ],
                Config::INCREMENTAL_TYPE_UPSERT
            );

            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_CARTS => $cart->id,
                    Config::COLLECTION_CART_PRODUCTS => $cart->id,
                ],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }
}
