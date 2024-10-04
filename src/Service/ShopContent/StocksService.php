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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\StockRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class StocksService implements ShopContentServiceInterface
{
    /** @var StockRepository */
    private $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $explainSql)
    {
        $result = $this->stockRepository->retrieveContentsForFull($offset, $limit, $langIso, $explainSql);

        if (empty($result)) {
            return [];
        }

        $this->castStocks($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_stock_available'],
                'collection' => Config::COLLECTION_STOCKS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $explainSql)
    {
        $result = $this->stockRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $explainSql);

        if (empty($result)) {
            return [];
        }

        $this->castStocks($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_stock_available'],
                'collection' => Config::COLLECTION_STOCKS,
                'properties' => $item,
            ];
        }, $result);
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
        return $this->stockRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $stocks
     * @param string $langIso
     *
     * @return void
     */
    private function castStocks(&$stocks, $langIso)
    {
        foreach ($stocks as &$stock) {
            $stock['id_stock_available'] = (int) $stock['id_stock_available'];
            $stock['id_product'] = (int) $stock['id_product'];
            $stock['id_product_attribute'] = (int) $stock['id_product_attribute'];
            $stock['id_shop'] = (int) $stock['id_shop'];
            $stock['id_shop_group'] = (int) $stock['id_shop_group'];
            $stock['quantity'] = (int) $stock['quantity'];

            $stock['depends_on_stock'] = (bool) $stock['depends_on_stock'];
            $stock['out_of_stock'] = (bool) $stock['out_of_stock'];

            // https://github.com/PrestaShop/PrestaShop/commit/2a3269ad93b1985f2615d6604458061d4989f0ea#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2186
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.2.0', '>=')) {
                $stock['physical_quantity'] = (int) $stock['physical_quantity'];
                $stock['reserved_quantity'] = (int) $stock['reserved_quantity'];
            }
        }
    }
}
