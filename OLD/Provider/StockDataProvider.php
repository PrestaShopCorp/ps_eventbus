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

if (!defined('_PS_VERSION_')) {
    exit;
}

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\StockDecorator;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\StockMvtRepository;
use PrestaShop\Module\PsEventbus\Repository\StockRepository;

class StockDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var StockRepository
     */
    private $stockRepository;
    /**
     * @var StockMvtRepository
     */
    private $stockMvtRepository;
    /**
     * @var StockDecorator
     */
    private $stockDecorator;
    /**
     * @var ArrayFormatter
     */
    private $arrayFormatter;

    public function __construct(
        StockRepository $stockRepository,
        StockMvtRepository $stockMvtRepository,
        StockDecorator $stockDecorator,
        ArrayFormatter $arrayFormatter
    ) {
        $this->stockRepository = $stockRepository;
        $this->stockMvtRepository = $stockMvtRepository;
        $this->stockDecorator = $stockDecorator;
        $this->arrayFormatter = $arrayFormatter;
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
        $stocks = $this->stockRepository->getStocks($offset, $limit);

        if (empty($stocks)) {
            return [];
        }
        $this->stockDecorator->decorateStocks($stocks);

        $stockMvts = $this->getStockMvts($langIso, $stocks);

        $stocks = array_map(function ($stock) {
            return [
                'id' => $stock['id_stock_available'],
                'collection' => Config::COLLECTION_STOCKS,
                'properties' => $stock,
            ];
        }, $stocks);

        return array_merge($stocks, $stockMvts);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->stockRepository->getRemainingStocksCount($offset);
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
        $stocks = $this->stockRepository->getStocksIncremental($limit, $objectIds);

        if (!is_array($stocks) || empty($stocks)) {
            return [];
        }

        $this->stockDecorator->decorateStocks($stocks);

        $stockMvts = $this->getStockMvts($langIso, $stocks);

        $stocks = array_map(function ($stock) {
            return [
                'id' => $stock['id_stock_available'],
                'collection' => Config::COLLECTION_STOCKS,
                'properties' => $stock,
            ];
        }, $stocks);

        return array_merge($stocks, $stockMvts);
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
        return $this->stockRepository->getQueryForDebug($offset, $limit);
    }

    /**
     * @param string $langIso
     * @param array<mixed> $stocks
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function getStockMvts($langIso, $stocks)
    {
        if (empty($stocks)) {
            return [];
        }

        $stockIds = $this->arrayFormatter->formatValueArray($stocks, 'id_stock_available');

        $stockMvts = $this->stockMvtRepository->getStockMvts($langIso, $stockIds);

        if (!is_array($stockMvts) || empty($stockMvts)) {
            return [];
        }

        $this->stockDecorator->decorateStockMvts($stockMvts);

        $stockMvts = array_map(function ($stockMvt) {
            return [
                'id' => $stockMvt['id_stock_mvt'],
                'collection' => Config::COLLECTION_STOCK_MVTS,
                'properties' => $stockMvt,
            ];
        }, $stockMvts);

        return $stockMvts;
    }
}
