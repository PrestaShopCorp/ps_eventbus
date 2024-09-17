<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class OrderDetailRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'order_detail';

    /**
     * @param string $tableName
     * @param string alias
     * 
     * @return void
     */
    public function generateMinimalQuery($tableName, $alias)
    {
        $this->query = new \DbQuery();

        $this->query->from($tableName, $alias);
    }

    /**
     * @param string $langIso
     * @param bool $withSelecParameters
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso, $withSelecParameters)
    {
        $context = \Context::getContext();

        if ($context == null) {
            throw new \PrestaShopException('Context is null');
        }

        if ($context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->generateMinimalQuery(self::TABLE_NAME, 'od');

        $this->query
            ->where('od.id_shop = ' . $context->shop->id)
            ->innerJoin('orders', 'o', 'od.id_order = o.id_order')
            ->leftJoin('order_slip_detail', 'osd', 'od.id_order_detail = osd.id_order_detail')
            ->leftJoin('product_shop', 'ps', 'od.product_id = ps.id_product AND ps.id_shop = ' . (int) $context->shop->id)
            ->leftJoin('currency', 'c', 'c.id_currency = o.id_currency')
            ->leftJoin('lang', 'l', 'o.id_lang = l.id_lang')
        ;
        
        if ($withSelecParameters) {
            $this->query
                ->select('od.id_order_detail')
                ->select('od.id_order')
                ->select('od.product_id')
                ->select('od.product_attribute_id')
                ->select('od.product_quantity')
                ->select('od.unit_price_tax_incl')
                ->select('od.unit_price_tax_excl')
                ->select('SUM(osd.total_price_tax_incl) as refund')
                ->select('SUM(osd.total_price_tax_excl) as refund_tax_excl')
                ->select('c.iso_code as currency')
                ->select('ps.id_category_default as category')
                ->select('l.iso_code')
                ->select('o.conversion_rate as conversion_rate')
            ;
        }
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);
        
        $this->query->groupBy('od.id_order_detail');

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery($debug);
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where('od.id_order_detail IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param $langIso
     * 
     * @return int
     * 
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, false);

        $this->query->select('(COUNT(*) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return $result[0]['count'];
    }
}
