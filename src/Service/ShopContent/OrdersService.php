<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Interfaces\ShopContentServiceInterface;
use PrestaShop\Module\PsEventbus\Repository\OrderHistoryRepository;
use PrestaShop\Module\PsEventbus\Repository\NewRepositoryTemp\OrderRepository;

class OrdersService implements ShopContentServiceInterface
{
    /** @var OrderRepository */
    private $orderRepository;

    /** @var OrderHistoryRepository */
    private $orderHistoryRepository;

    /** @var ArrayFormatter */
    private $arrayFormatter;

    public function __construct(
        OrderRepository $orderRepository,
        OrderHistoryRepository $orderHistoryRepository,
        ArrayFormatter $arrayFormatter
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderHistoryRepository = $orderHistoryRepository;
        $this->arrayFormatter = $arrayFormatter;
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
        $orders = $this->orderRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($orders)) {
            return [];
        }

        $this->castOrders($orders, $langIso);

        return array_map(function ($order) {
            return [
                'id' => $order['id_order'],
                'collection' => Config::COLLECTION_ORDERS,
                'properties' => $order,
            ];
        }, $orders);
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
        $orders = $this->orderRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($orders)) {
            return [];
        }

        $this->castOrders($orders, $langIso);

        return array_map(function ($order) {
            return [
                'id' => $order['id_order'],
                'collection' => Config::COLLECTION_ORDERS,
                'properties' => $order,
            ];
        }, $orders);
    }

    /**
     * @param int $offset
     * @param string $langIso
     * @param bool $debug
     *
     * @return int
     */
    public function countFullSyncContentLeft($offset, $langIso, $debug)
    {
        return (int) $this->orderRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }

    /**
     * @param array<mixed> $orders
     * @param string $langIso
     *
     * @return void
     */
    public function castOrders(&$orders, $langIso)
    {
        $langId = (int) \Language::getIdByIso($langIso);

        foreach ($orders as &$order) {
            $order['id_order'] = (int) $order['id_order'];
            $order['id_customer'] = (int) $order['id_customer'];
            $order['current_state'] = (int) $order['current_state'];
            $order['conversion_rate'] = (float) $order['conversion_rate'];
            $order['total_paid_tax_incl'] = (float) $order['total_paid_tax_incl'];
            $order['total_paid_tax_excl'] = (float) $order['total_paid_tax_excl'];
            $order['refund'] = (float) $order['refund'];
            $order['refund_tax_excl'] = (float) $order['refund_tax_excl'];
            $order['new_customer'] = $order['new_customer'] == 1;
            $order['is_paid'] = $this->castIsPaidValue($orders, $order, $langId);
            $order['shipping_cost'] = (float) $order['shipping_cost'];
            $order['total_paid_tax'] = $order['total_paid_tax_incl'] - $order['total_paid_tax_excl'];
            $order['id_carrier'] = (int) $order['id_carrier'];

            $order['id_shop_group'] = (int) $order['id_shop_group'];
            $order['id_shop'] = (int) $order['id_shop'];
            $order['id_lang'] = (int) $order['id_lang'];
            $order['id_currency'] = (int) $order['id_currency'];
            $order['recyclable'] = (bool) $order['recyclable'];
            $order['gift'] = (bool) $order['gift'];

            $order['total_discounts'] = (int) $order['total_discounts'];
            $order['total_discounts_tax_incl'] = (int) $order['total_discounts_tax_incl'];
            $order['total_discounts_tax_excl'] = (int) $order['total_discounts_tax_excl'];
            $order['total_products'] = (int) $order['total_products'];
            $order['total_products_wt'] = (int) $order['total_products_wt'];
            $order['total_shipping_tax_incl'] = (int) $order['total_shipping_tax_incl'];
            $order['total_shipping_tax_excl'] = (int) $order['total_shipping_tax_excl'];

            $order['carrier_tax_rate'] = (int) $order['carrier_tax_rate'];
            $order['total_wrapping'] = (int) $order['total_wrapping'];
            $order['total_wrapping_tax_incl'] = (int) $order['total_wrapping_tax_incl'];
            $order['total_wrapping_tax_excl'] = (int) $order['total_wrapping_tax_excl'];
            $order['round_mode'] = (int) $order['round_mode'];
            $order['round_type'] = (int) $order['round_type'];
            $order['invoice_number'] = (int) $order['invoice_number'];
            $order['delivery_number'] = (int) $order['delivery_number'];
            $order['valid'] = (bool) $order['valid'];

            $this->castAddressIsoCodes($order);
            unset($order['address_iso']);
        }
    }

    /**
     * @param array<mixed> $orders
     * @param array<mixed> $order
     * @param int|null $langId
     *
     * @return bool
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function castIsPaidValue($orders, $order, $langId)
    {
        $isPaid = $dateAdd = 0;
        $orderIds = $this->arrayFormatter->formatValueArray($orders, 'id_order');
        /** @var array<mixed> $orderHistoryStatuses */
        $orderHistoryStatuses = $this->orderHistoryRepository->getOrderHistoryStatuses($orderIds, $langId);

        foreach ($orderHistoryStatuses as &$orderHistoryStatus) {
            if ($order['id_order'] == $orderHistoryStatus['id_order'] && $dateAdd < $orderHistoryStatus['date_add']) {
                $isPaid = (bool) $orderHistoryStatus['paid'];
                $dateAdd = $orderHistoryStatus['date_add'];
            }
        }

        return (bool) $isPaid;
    }

    /**
     * @param array<mixed> $orderDetail
     *
     * @return void
     */
    private function castAddressIsoCodes(&$orderDetail)
    {
        if (!$orderDetail['address_iso']) {
            $orderDetail['invoice_country_code'] = null;
            $orderDetail['delivery_country_code'] = null;

            return;
        }

        $addressAndIsoCodes = explode(',', $orderDetail['address_iso']);
        if (count($addressAndIsoCodes) === 1) {
            $addressAndIsoCode = explode(':', $addressAndIsoCodes[0]);
            $orderDetail['invoice_country_code'] = $addressAndIsoCode[1];
            $orderDetail['delivery_country_code'] = $addressAndIsoCode[1];

            return;
        }

        foreach ($addressAndIsoCodes as $addressAndIsoCodeString) {
            $addressAndIsoCode = explode(':', $addressAndIsoCodeString);
            if ($addressAndIsoCode[0] === 'delivery') {
                $orderDetail['delivery_country_code'] = $addressAndIsoCode[1];
            } elseif ($addressAndIsoCode[0] === 'invoice') {
                $orderDetail['invoice_country_code'] = $addressAndIsoCode[1];
            }
        }
    }
}
