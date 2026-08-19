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
     * @param string|null $lastSeekKey
     * @param int $limit
     * @param string $langIso
     *
     * @return array{rows: array<mixed>, lastSeekKey: ?string}
     */
    public function getContentsForFull($lastSeekKey, $limit, $langIso)
    {
        $result = $this->orderRepository->retrieveContentsForFull($lastSeekKey, $limit, $langIso);

        $newSeekKey = $lastSeekKey;
        $rows = [];

        if (!empty($result)) {
            $lastRow = end($result);
            $newSeekKey = (string) (int) $lastRow['id_order'];

            $this->castOrders($result, $langIso);

            $rows = array_map(function ($item) {
                return [
                    'action' => Config::INCREMENTAL_TYPE_UPSERT,
                    'collection' => Config::COLLECTION_ORDERS,
                    'properties' => $item,
                ];
            }, $result);
        }

        return [
            'rows' => $rows,
            'lastSeekKey' => $newSeekKey,
        ];
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
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($lastSeekKey, $langIso)
    {
        return $this->orderRepository->countFullSyncContentLeft($lastSeekKey, $langIso);
    }

    /**
     * @param array<mixed> $orders
     * @param string $langIso
     *
     * @return void
     */
    private function castOrders(&$orders, $langIso)
    {
        // Compute the latest paid-state per order ONCE for the whole page.
        // Previously castIsPaidValue() was called inside the loop below, and each
        // call re-ran the full order_history JOIN for every id in the page: O(n)
        // identical queries + O(n^2) PHP scan per page. On shops with >1M orders
        // that blew the request timeout and full sync never progressed.
        $isPaidByOrderId = $this->buildIsPaidMap($orders, $langIso);

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
            $order['is_paid'] = isset($isPaidByOrderId[(int) $order['id_order']])
                ? $isPaidByOrderId[(int) $order['id_order']]
                : false;
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
     * Build a map id_order => is_paid for the whole page in a single query.
     *
     * is_paid reflects the most recent status in order_history (max date_add).
     * Tie-break preserves the previous behavior: rows arrive ordered by
     * id_order_history ASC and the first row reaching the max date wins.
     *
     * @param array<mixed> $orders
     * @param string $langIso
     *
     * @return array<int, bool>
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function buildIsPaidMap($orders, $langIso)
    {
        $orderIds = $this->arrayFormatter->formatValueArray($orders, 'id_order');

        if (empty($orderIds)) {
            return [];
        }

        /** @var array<mixed> $orderStatusHistories */
        $orderStatusHistories = $this->orderStatusHistoryRepository->getOrderStatusHistoriesByOrderIds($orderIds, $langIso);

        $isPaidByOrderId = [];
        $latestDateByOrderId = [];

        foreach ($orderStatusHistories as $history) {
            $orderId = (int) $history['id_order'];
            $dateAdd = $history['date_add'];

            if (!isset($latestDateByOrderId[$orderId]) || $latestDateByOrderId[$orderId] < $dateAdd) {
                $latestDateByOrderId[$orderId] = $dateAdd;
                $isPaidByOrderId[$orderId] = (bool) $history['is_paid'];
            }
        }

        return $isPaidByOrderId;
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
