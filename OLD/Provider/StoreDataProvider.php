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

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\StoreDecorator;
use PrestaShop\Module\PsEventbus\Repository\StoreRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class StoreDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var StoreRepository
     */
    private $storeRepository;
    /**
     * @var StoreDecorator
     */
    private $storeDecorator;

    public function __construct(StoreRepository $storeRepository, StoreDecorator $storeDecorator)
    {
        $this->storeRepository = $storeRepository;
        $this->storeDecorator = $storeDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $stores = $this->storeRepository->getStores($offset, $limit, $langIso);

        if (!is_array($stores)) {
            return [];
        }

        $this->storeDecorator->decorateStores($stores);

        return array_map(function ($store) {
            return [
                'id' => $store['id_store'],
                'collection' => Config::COLLECTION_STORES,
                'properties' => $store,
            ];
        }, $stores);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->storeRepository->getRemainingStoreCount($offset, $langIso);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $objectIds
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $stores = $this->storeRepository->getStoresIncremental($limit, $langIso, $objectIds);

        if (!is_array($stores)) {
            return [];
        }

        $this->storeDecorator->decorateStores($stores);

        return array_map(function ($store) {
            return [
                'id' => $store['id_store'],
                'collection' => Config::COLLECTION_STORES,
                'properties' => $store,
            ];
        }, $stores);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->storeRepository->getQueryForDebug($offset, $limit, $langIso);
    }
}
