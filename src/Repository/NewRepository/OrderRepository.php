<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class OrderRepository extends AbstractRepository implements RepositoryInterface
{
    const ORDERS_TABLE = 'orders';

    /**
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateBaseQuery()
    {
        $this->query = new \DbQuery();

        $this->query->from(self::ORDERS_TABLE, 'o')
            ->leftJoin('currency', 'c', 'o.id_currency = c.id_currency')
            ->leftJoin('order_slip', 'os', 'o.id_order = os.id_order')
            ->leftJoin('address', 'ad', 'ad.id_address = o.id_address_delivery')
            ->leftJoin('address', 'ai', 'ai.id_address = o.id_address_invoice')
            ->leftJoin('country', 'cntd', 'cntd.id_country = ad.id_country')
            ->leftJoin('country', 'cnti', 'cnti.id_country = ai.id_country')
            ->leftJoin('order_state_lang', 'osl', 'o.current_state = osl.id_order_state')
            ->leftJoin('order_state', 'ost', 'o.current_state = ost.id_order_state')
            ->where('o.id_shop = ' . (int) parent::getShopId())
            ->groupBy('o.id_order');

        $this->query->select('o.id_order');
        $this->query->select('o.reference');
        $this->query->select('o.id_customer');
        $this->query->select('o.id_cart');
        $this->query->select('o.current_state');
        $this->query->select('o.conversion_rate');
        $this->query->select('o.total_paid_tax_excl');
        $this->query->select('o.total_paid_tax_incl');

        $this->query->select('c.iso_code as currency');
        $this->query->select('o.module as payment_module');
        $this->query->select('o.payment as payment_mode');
        $this->query->select('o.total_paid_real');
        $this->query->select('o.total_shipping as shipping_cost');
        $this->query->select('o.date_add as created_at');
        $this->query->select('o.date_upd as updated_at');
        $this->query->select('o.id_carrier');
        $this->query->select('o.payment as payment_name');
        $this->query->select('o.valid as is_validated');
        $this->query->select('ost.paid as is_paid');
        $this->query->select('ost.shipped as is_shipped');
        $this->query->select('osl.name as status_label');
        $this->query->select('o.module as payment_name');
        $this->query->select('o.id_shop_group');
        $this->query->select('o.id_shop');
        $this->query->select('o.id_lang');
        $this->query->select('o.id_currency');
        $this->query->select('o.recyclable');
        $this->query->select('o.gift');
        $this->query->select('o.total_discounts');
        $this->query->select('o.total_discounts_tax_incl');
        $this->query->select('o.total_discounts_tax_excl');
        $this->query->select('o.total_products');
        $this->query->select('o.total_products_wt');
        $this->query->select('o.total_shipping_tax_incl');
        $this->query->select('o.total_shipping_tax_excl');
        $this->query->select('o.carrier_tax_rate');
        $this->query->select('o.total_wrapping');
        $this->query->select('o.total_wrapping_tax_incl');
        $this->query->select('o.total_wrapping_tax_excl');
        $this->query->select('o.round_mode');
        $this->query->select('o.round_type');
        $this->query->select('o.invoice_number');
        $this->query->select('o.delivery_number');
        $this->query->select('o.invoice_date');
        $this->query->select('o.delivery_date');
        $this->query->select('o.valid');

        $this->query->select('SUM(os.total_products_tax_incl + os.total_shipping_tax_incl) as refund');
        $this->query->select('SUM(os.total_products_tax_excl + os.total_shipping_tax_excl) as refund_tax_excl');
        $this->query->select('CONCAT(CONCAT("delivery", ":", cntd.iso_code), ",", CONCAT("invoice", ":", cnti.iso_code)) as address_iso');
        $this->query->select('IF((SELECT so.id_order FROM `' . _DB_PREFIX_ . 'orders` so WHERE so.id_customer = o.id_customer AND so.id_order < o.id_order LIMIT 1) > 0, 0, 1) as new_customer');
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
        $this->generateBaseQuery();

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
        $this->generateBaseQuery();

        $this->query->where('o.id_order IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit);

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
