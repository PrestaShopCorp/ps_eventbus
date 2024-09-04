<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class OrderDetailRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'order_detail';

    /**
     * @param string $langIso
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateBaseQuery($langIso)
    {
        $context = \Context::getContext();

        if ($context === null) {
            throw new \PrestaShopException('Context is null');
        }

        if ($context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->query = new \DbQuery();

        $this->query
            ->from(self::TABLE_NAME, 'od')
            ->where('od.id_shop = ' . $context->shop->id)
            ->innerJoin('orders', 'o', 'od.id_order = o.id_order')
            ->leftJoin('order_slip_detail', 'osd', 'od.id_order_detail = osd.id_order_detail')
            ->leftJoin('product_shop', 'ps', 'od.product_id = ps.id_product AND ps.id_shop = ' . (int) $context->shop->id)
            ->leftJoin('currency', 'c', 'c.id_currency = o.id_currency')
            ->leftJoin('lang', 'l', 'o.id_lang = l.id_lang')
            ->groupBy('od.id_order_detail')
        ;

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
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $this->generateBaseQuery($langIso);

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
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $this->generateBaseQuery($langIso);

        $this->query
            ->where('o.id_order IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     * @param string $langIso
     * @param bool $debug
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $langIso, $debug)
    {
        $result = $this->getContentsForFull($offset, 1, $langIso, $debug);

        if (!is_array($result) || empty($result)) {
            return 0;
        }

        return count($result);
    }
}