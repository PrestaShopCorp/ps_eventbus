<?php

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
     * @return array
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
     * @param array $objectIds
     *
     * @return array
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
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->stockRepository->getQueryForDebug($offset, $limit);
    }

    /**
     * @param string $langIso
     * @param array $stocks
     *
     * @return array
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
