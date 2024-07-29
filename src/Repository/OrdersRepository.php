<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Interfaces\RepositoryInterface;
use PrestaShop\Module\PsEventbus\Repository\AbstractRepository;

class OrdersRepository extends AbstractRepository implements RepositoryInterface
{
    public const ORDERS_TABLE = 'orders';

    public function __construct(\Context $context)
    {
        parent::__construct($context);
    }

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

        $this->query->select('o.id_order, o.reference, o.id_customer, o.id_cart, o.current_state');
        $this->query->select('o.conversion_rate, o.total_paid_tax_excl, o.total_paid_tax_incl');
        $this->query->select('IF((SELECT so.id_order FROM `' . _DB_PREFIX_ . 'orders` so WHERE so.id_customer = o.id_customer AND so.id_order < o.id_order LIMIT 1) > 0, 0, 1) as new_customer');
        $this->query->select('c.iso_code as currency, SUM(os.total_products_tax_incl + os.total_shipping_tax_incl) as refund');
        $this->query->select('SUM(os.total_products_tax_excl + os.total_shipping_tax_excl) as refund_tax_excl, o.module as payment_module');
        $this->query->select('o.payment as payment_mode, o.total_paid_real, o.total_shipping as shipping_cost, o.date_add as created_at');
        $this->query->select('o.date_upd as updated_at, o.id_carrier');
        $this->query->select('o.payment as payment_name');
        $this->query->select('CONCAT(CONCAT("delivery", ":", cntd.iso_code), ",", CONCAT("invoice", ":", cnti.iso_code)) as address_iso');
        $this->query->select('o.valid as is_validated');
        $this->query->select('ost.paid as is_paid');
        $this->query->select('ost.shipped as is_shipped');
        $this->query->select('osl.name as status_label');
        $this->query->select('o.module as payment_name');

        $this->query->select('o.id_shop_group, o.id_shop, o.id_lang, o.id_currency, o.recyclable, o.gift');
        $this->query->select('o.total_discounts, o.total_discounts_tax_incl, o.total_discounts_tax_excl');
        $this->query->select('o.total_products, o.total_products_wt, o.total_shipping_tax_incl, o.total_shipping_tax_excl');
        $this->query->select('o.carrier_tax_rate, o.total_wrapping, o.total_wrapping_tax_incl, o.total_wrapping_tax_excl');
        $this->query->select('o.round_mode, o.round_type, o.invoice_number, o.delivery_number, o.invoice_date, o.delivery_date, o.valid');
    }

    public function getContentsForFull($offset, $limit, $langIso = null, $debug = false)
    {
        $this->generateBaseQuery();

        $this->query->limit((int) $limit, (int) $offset);

        if ($debug) {
            return $this->debugQuery();
        } else {
            return $this->executeQuery();
        }
        
    }

    public function getContentsForIncremental($limit, $contentIds, $langIso = null, $debug = false)
    {
        $this->generateBaseQuery();

        $this->query->where('o.id_order IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit);

        if ($debug) {
            return $this->debugQuery();
        } else {
            return $this->executeQuery();
        }
    }

    public function countFullSyncContentLeft($offset, $langIso = null, $debug = false)
    {
        $orders = $this->getContentsForFull($offset, 1, parent::getShopId());

        if (!is_array($orders) || empty($orders)) {
            return 0;
        }

        return count($orders);
    }
}
