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

trait UseCombinationHooks
{
    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCombinationAddAfter($parameters)
    {
        $this->sendUpsertCombination($parameters);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCombinationUpdateAfter($parameters)
    {
        $this->sendUpsertCombination($parameters);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCombinationDeleteAfter($parameters)
    {
        /** @var \Combination $combination */
        $combination = $parameters['object'];

        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $uniqueProductId = $combination->id_product . '-' . $combination->id;

        if (isset($combination->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_PRODUCTS, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_PRODUCTS => $uniqueProductId],
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
    private function sendUpsertCombination($parameters)
    {
        /** @var \Combination $combination */
        $combination = $parameters['object'];

        /** @var \Product $product */
        $product = new \Product($combination->id_product);

        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var CustomProductCarrierRepository $customProductCarrierRepository */
        $customProductCarrierRepository = $this->getService(CustomProductCarrierRepository::class);

        /** @var ProductRepository $productRepository */
        $productRepository = $this->getService(ProductRepository::class);

        $customProductCarrierList = $customProductCarrierRepository->getCustomProductCarrierIdsByProductId($combination->id_product);
        $customProductCarrierIds = array_column($customProductCarrierList, 'id_carrier_reference');

        $uniqueProductIdList = $productRepository->getUniqueProductIdsFromProductId($combination->id_product);
        $uniqueProductIds = array_column($uniqueProductIdList, 'id_product_attribute');

        $liveSyncItems = [
            Config::COLLECTION_PRODUCTS,
            Config::COLLECTION_PRODUCT_SUPPLIERS,
            Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
        ];

        $incrementalSyncItems = [
            Config::COLLECTION_PRODUCTS => $uniqueProductIds,
            Config::COLLECTION_PRODUCT_SUPPLIERS => $combination->id_product,
            Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS => $customProductCarrierIds,
        ];

        // is for bundle only
        if ($product->cache_is_pack) {
            $liveSyncItems[] = Config::COLLECTION_BUNDLES;
            $incrementalSyncItems[Config::COLLECTION_BUNDLES] = $combination->id_product;
        }

        $synchronizationService->sendLiveSync(
            $liveSyncItems,
            Config::INCREMENTAL_TYPE_UPSERT
        );

        $synchronizationService->insertContentIntoIncremental(
            $incrementalSyncItems,
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            true
        );

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_PRODUCTS => $combination->id_product],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }
}
