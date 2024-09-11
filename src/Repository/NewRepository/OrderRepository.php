<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class OrderRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'orders';

    /**
     *
     * @return void
     */
    public function generateMinimalQuery()
    {
        $this->query = new \DbQuery();

        $this->query->from(self::TABLE_NAME, 'o');
    }

    /**
     * @param string $langIso
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso)
    {
        $this->generateMinimalQuery();

        $this->query
            ->leftJoin('currency', 'c', 'o.id_currency = c.id_currency')
            ->leftJoin('order_slip', 'os', 'o.id_order = os.id_order')
            ->leftJoin('address', 'ad', 'ad.id_address = o.id_address_delivery')
            ->leftJoin('address', 'ai', 'ai.id_address = o.id_address_invoice')
            ->leftJoin('country', 'cntd', 'cntd.id_country = ad.id_country')
            ->leftJoin('country', 'cnti', 'cnti.id_country = ai.id_country')
            ->leftJoin('order_state_lang', 'osl', 'o.current_state = osl.id_order_state')
            ->leftJoin('order_state', 'ost', 'o.current_state = ost.id_order_state')
            ->where('o.id_shop = ' . (int) parent::getShopId())
            ->groupBy('o.id_order')
        ;

        $this->query
            ->select('o.id_order')
            ->select('o.reference')
            ->select('o.id_customer')
            ->select('o.id_cart')
            ->select('o.current_state')
            ->select('o.conversion_rate')
            ->select('o.total_paid_tax_excl')
            ->select('o.total_paid_tax_incl')
            ->select('c.iso_code as currency')
            ->select('o.module as payment_module')
            ->select('o.payment as payment_mode')
            ->select('o.total_paid_real')
            ->select('o.total_shipping as shipping_cost')
            ->select('o.date_add as created_at')
            ->select('o.date_upd as updated_at')
            ->select('o.id_carrier')
            ->select('o.payment as payment_name')
            ->select('o.valid as is_validated')
            ->select('ost.paid as is_paid')
            ->select('ost.shipped as is_shipped')
            ->select('osl.name as status_label')
            ->select('o.module as payment_name')
            ->select('o.id_shop_group')
            ->select('o.id_shop')
            ->select('o.id_lang')
            ->select('o.id_currency')
            ->select('o.recyclable')
            ->select('o.gift')
            ->select('o.total_discounts')
            ->select('o.total_discounts_tax_incl')
            ->select('o.total_discounts_tax_excl')
            ->select('o.total_products')
            ->select('o.total_products_wt')
            ->select('o.total_shipping_tax_incl')
            ->select('o.total_shipping_tax_excl')
            ->select('o.carrier_tax_rate')
            ->select('o.total_wrapping')
            ->select('o.total_wrapping_tax_incl')
            ->select('o.total_wrapping_tax_excl')
            ->select('o.round_mode')
            ->select('o.round_type')
            ->select('o.invoice_number')
            ->select('o.delivery_number')
            ->select('o.invoice_date')
            ->select('o.delivery_date')
            ->select('o.valid')
            ->select('SUM(os.total_products_tax_incl + os.total_shipping_tax_incl) as refund')
            ->select('SUM(os.total_products_tax_excl + os.total_shipping_tax_excl) as refund_tax_excl')
            ->select('CONCAT(CONCAT("delivery", ":", cntd.iso_code), ",", CONCAT("invoice", ":", cnti.iso_code)) as address_iso')
            ->select('IF((SELECT so.id_order FROM `' . _DB_PREFIX_ . 'orders` so WHERE so.id_customer = o.id_customer AND so.id_order < o.id_order LIMIT 1) > 0, 0, 1) as new_customer')
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
        $this->generateFullQuery($langIso);

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
        $this->generateFullQuery($langIso);

        $this->query
            ->where('o.id_order IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset)
    {
        $this->generateMinimalQuery();

        $this->query->select('(COUNT(o.id_order) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return is_array($result) ? $result[0]['count'] : 0;
    }
}
