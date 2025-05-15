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
use PrestaShop\Module\PsEventbus\Repository\CustomProductCarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\ProductRepository;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;

if (!defined('_PS_VERSION_')) {
    exit;
}

trait UseProductHooks
{
    /**
     * @var bool
     */
    private static $firstCallReceived = false;

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectProductAddAfter($parameters)
    {
        $this->sendUpsertProduct($parameters);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectProductUpdateAfter($parameters)
    {
        $this->sendUpsertProduct($parameters);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectProductDeleteAfter($parameters)
    {
        /** @var \Product $product */
        $product = $parameters['object'];

        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        if (isset($product->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_PRODUCTS, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_PRODUCTS => $product->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    private function sendUpsertProduct($parameters)
    {
        /** @var \Product $product */
        $product = $parameters['object'];

        if (!isset($product->id)) {
            return;
        }

        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var CustomProductCarrierRepository $customProductCarrierRepository */
        $customProductCarrierRepository = $this->getService(CustomProductCarrierRepository::class);

        /** @var ProductRepository $productRepository */
        $productRepository = $this->getService(ProductRepository::class);

        $customProductCarrierList = $customProductCarrierRepository->getCustomProductCarrierIdsByProductId($product->id);
        $customProductCarrierIds = array_column($customProductCarrierList, 'id_custom_product_carrier');

        $uniqueProductIdList = $productRepository->getUniqueProductIdsFromProductId($product->id);
        $uniqueProductIds = array_column($uniqueProductIdList, 'id_product_attribute');

        $liveSyncItems = [
            Config::COLLECTION_PRODUCTS,
            Config::COLLECTION_PRODUCT_SUPPLIERS,
            Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
        ];

        $incrementalSyncItems = [
            Config::COLLECTION_PRODUCTS => $uniqueProductIds,
            Config::COLLECTION_PRODUCT_SUPPLIERS => $product->id,
        ];

        // is for bundle only
        if ($product->cache_is_pack) {
            $liveSyncItems[] = Config::COLLECTION_BUNDLES;
            $incrementalSyncItems[Config::COLLECTION_BUNDLES] = $product->id;
        }

        /*
        * This trick is here to compensate for the fact that this hook is called multiple times in a row when saving a product, in V2 product page.
        * On the first call, we receive the old version of the carriers, and then we receive the new version six times.
        * With this piece of code, we ensure that the previous state is marked as "delete" and upsert only what is actually defined.
        *
        * For the Legacy page, we don't have this problem, because the hook is called only once. But we need to handle it differently.
        * In the legacy page, we have the selected carriers only, but we don't have the list of carrier was unselected before.
        *
        * We have condition for webservice because the webservice is not front office call, and controller doesn't exist.
        * We need to handle it differently, with the presence of the webservice container.
        */
        if (
            \Context::getContext()->controller instanceof \AdminProductsController
            || (isset(\Context::getContext()->container) && \Context::getContext()->container != null && get_class(\Context::getContext()->container) == 'WebserviceContainer') // <== Trick for webservice only
        ) {
            // We are on legacy product page
            $incrementalSyncItems[Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS] = $customProductCarrierIds;

            $productCarrierIdList = $customProductCarrierRepository->getAllAvailableProductCarrierIdsForProduct($product->id);
            $productCarrierIds = array_column($productCarrierIdList, 'custom_product_carrier_id');

            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS => $productCarrierIds],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                true
            );

            $synchronizationService->insertContentIntoIncremental(
                $incrementalSyncItems,
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        } else {
            // we are on v2 product page
            if (!self::$firstCallReceived) {
                self::$firstCallReceived = true;

                $synchronizationService->insertContentIntoIncremental(
                    [Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS => $customProductCarrierIds],
                    Config::INCREMENTAL_TYPE_DELETE,
                    date(DATE_ATOM),
                    $this->shopId,
                    true
                );
            } else {
                $incrementalSyncItems[Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS] = $customProductCarrierIds;

                $synchronizationService->insertContentIntoIncremental(
                    $incrementalSyncItems,
                    Config::INCREMENTAL_TYPE_UPSERT,
                    date(DATE_ATOM),
                    $this->shopId,
                    true
                );

                $synchronizationService->sendLiveSync(
                    $liveSyncItems,
                    Config::INCREMENTAL_TYPE_UPSERT
                );
            }
        }
    }
}
