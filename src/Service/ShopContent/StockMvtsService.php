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
use PrestaShop\Module\PsEventbus\Repository\NewRepository\StockMvtRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class StockMvtsService implements ShopContentServiceInterface
{
    /** @var StockMvtRepository */
    private $stockMvtRepository;

    public function __construct(StockMvtRepository $stockMvtRepository)
    {
        $this->stockMvtRepository = $stockMvtRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->stockMvtRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castStockMvts($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_stock_mvt'],
                'collection' => Config::COLLECTION_STOCK_MVTS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->stockMvtRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castStockMvts($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_stock_mvt'],
                'collection' => Config::COLLECTION_STOCK_MVTS,
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
        return $this->stockMvtRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $stockMvts
     * @param string $langIso
     *
     * @return void
     */
    private function castStockMvts(&$stockMvts, $langIso)
    {
        foreach ($stockMvts as &$stockMvt) {
            $date = $stockMvt['date_add'];

            $stockMvt['id_stock_mvt'] = (int) $stockMvt['id_stock_mvt'];
            $stockMvt['id_stock'] = (int) $stockMvt['id_stock'];
            $stockMvt['id_order'] = (int) $stockMvt['id_order'];
            $stockMvt['id_supply_order'] = (int) $stockMvt['id_supply_order'];
            $stockMvt['id_stock_mvt_reason'] = (int) $stockMvt['id_stock_mvt_reason'];
            $stockMvt['id_lang'] = (int) $stockMvt['id_lang'];
            $stockMvt['id_employee'] = (int) $stockMvt['id_employee'];
            $stockMvt['physical_quantity'] = (int) $stockMvt['physical_quantity'];
            $stockMvt['date_add'] = $date;
            $stockMvt['sign'] = (int) $stockMvt['sign'];
            $stockMvt['price_te'] = (float) $stockMvt['price_te'];
            $stockMvt['last_wa'] = (float) $stockMvt['last_wa'];
            $stockMvt['current_wa'] = (float) $stockMvt['current_wa'];
            $stockMvt['referer'] = (int) $stockMvt['referer'];
            $stockMvt['deleted'] = (bool) $stockMvt['deleted'];
            $stockMvt['created_at'] = $date;
        }
    }
}
