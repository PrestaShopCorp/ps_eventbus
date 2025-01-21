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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\StoreRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class StoresService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var StoreRepository */
    private $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->storeRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castStores($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_STORES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        $result = $this->storeRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castStores($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_STORES, $result, $deletedContents);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->storeRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $stores
     *
     * @return void
     */
    private function castStores(&$stores)
    {
        foreach ($stores as &$store) {
            $store['id_store'] = (int) $store['id_store'];
            $store['id_country'] = (int) $store['id_country'];
            $store['id_state'] = (int) $store['id_state'];
            $store['active'] = (bool) $store['active'];
            $store['created_at'] = (string) $store['created_at'];
            $store['updated_at'] = (string) $store['updated_at'];

            // https://github.com/PrestaShop/PrestaShop/commit/7dda2be62d8bd606edc269fa051c36ea68f81682#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2004
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
                $store['id_lang'] = (int) $store['id_lang'];
                $store['id_shop'] = (int) $store['id_shop'];
            }
        }
    }
}
