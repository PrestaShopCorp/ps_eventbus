<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class StockDecorator
{
    /**
     * @param array<mixed> $stocks
     *
     * @return void
     */
    public function decorateStocks(&$stocks)
    {
        foreach ($stocks as &$stock) {
            $this->castStockPropertyValues($stock);
        }
    }

    /**
     * @param array<mixed> $stock
     *
     * @return void
     */
    private function castStockPropertyValues(&$stock)
    {
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

    /**
     * @param array<mixed> $stockMvts
     *
     * @return void
     */
    public function decorateStockMvts(&$stockMvts)
    {
        foreach ($stockMvts as &$stockMvt) {
            $this->castStockMvtPropertyValues($stockMvt);
        }
    }

    /**
     * @param array<mixed> $stockMvt
     *
     * @return void
     */
    private function castStockMvtPropertyValues(&$stockMvt)
    {
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
