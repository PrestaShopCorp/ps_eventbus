<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\OrderRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderStatusHistoryRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrdersService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var OrderRepository */
    private $orderRepository;

    /** @var OrderStatusHistoryRepository */
    private $orderStatusHistoryRepository;

    /** @var ArrayFormatter */
    private $arrayFormatter;

    public function __construct(
        OrderRepository $orderRepository,
        OrderStatusHistoryRepository $orderStatusHistoryRepository,
        ArrayFormatter $arrayFormatter
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderStatusHistoryRepository = $orderStatusHistoryRepository;
        $this->arrayFormatter = $arrayFormatter;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->orderRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castOrders($result, $langIso);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_ORDERS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        $result = $this->orderRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castOrders($result, $langIso);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_ORDERS, $result, $deletedContents);
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
        return $this->orderRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $orders
     * @param string $langIso
     *
     * @return void
     */
    private function castOrders(&$orders, $langIso)
    {
        foreach ($orders as &$order) {
            $order['id_order'] = (int) $order['id_order'];
            $order['id_cart'] = (string) $order['id_cart'];
            $order['id_customer'] = (int) $order['id_customer'];
            $order['current_state'] = (int) $order['current_state'];
            $order['conversion_rate'] = (float) $order['conversion_rate'];
            $order['total_paid_tax_incl'] = (float) $order['total_paid_tax_incl'];
            $order['total_paid_tax_excl'] = (float) $order['total_paid_tax_excl'];
            $order['refund'] = (float) $order['refund'];
            $order['refund_tax_excl'] = (float) $order['refund_tax_excl'];
            $order['new_customer'] = $order['new_customer'] == 1;
            $order['is_paid'] = $this->castIsPaidValue($orders, $order, $langIso);
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

            $order['is_shipped'] = (string) $order['is_shipped'];
            $order['is_validated'] = (string) $order['is_validated'];

            $this->castAddressIsoCodes($order);

            // remove extra properties
            unset($order['address_iso']);
        }
    }

    /**
     * @param array<mixed> $orders
     * @param array<mixed> $order
     * @param string $langIso
     *
     * @return bool
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function castIsPaidValue($orders, $order, $langIso)
    {
        $isPaid = $dateAdd = 0;
        $orderIds = $this->arrayFormatter->formatValueArray($orders, 'id_order');
        /** @var array<mixed> $orderStatusHistories */
        $orderStatusHistories = $this->orderStatusHistoryRepository->getOrderStatusHistoriesByOrderIds($orderIds, $langIso);

        foreach ($orderStatusHistories as &$orderStatusHistory) {
            if ($order['id_order'] == $orderStatusHistory['id_order'] && $dateAdd < $orderStatusHistory['date_add']) {
                $isPaid = (bool) $orderStatusHistory['is_paid'];
                $dateAdd = $orderStatusHistory['date_add'];
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
