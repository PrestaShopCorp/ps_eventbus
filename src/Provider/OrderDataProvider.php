<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\OrderCartRuleRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderDetailsRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderHistoryRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderRepository;

class OrderDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var ArrayFormatter
     */
    private $arrayFormatter;
    /**
     * @var OrderDetailsRepository
     */
    private $orderDetailsRepository;
    /**
     * @var OrderHistoryRepository
     */
    private $orderHistoryRepository;
    /**
     * @var OrderCartRuleRepository
     */
    private $orderCartRuleRepository;

    /**
     * @var int
     */
    private $shopId;

    public function __construct(
        \Context $context,
        OrderRepository $orderRepository,
        OrderDetailsRepository $orderDetailsRepository,
        ArrayFormatter $arrayFormatter,
        OrderHistoryRepository $orderHistoryRepository,
        OrderCartRuleRepository $orderCartRuleRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->context = $context;
        $this->arrayFormatter = $arrayFormatter;
        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->orderHistoryRepository = $orderHistoryRepository;
        $this->orderCartRuleRepository = $orderCartRuleRepository;

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $orders = $this->orderRepository->getOrders($offset, $limit, $this->shopId);

        if (empty($orders)) {
            return [];
        }

        $langId = (int) \Language::getIdByIso($langIso);
        $this->castOrderValues($orders, $langId);

        $orderDetails = $this->getOrderDetails($orders);
        $orderStatuses = $this->getOrderStatuses($orders, $langId);
        $orderCartRules = $this->getOrderCartRules($orders);

        $orders = array_map(function ($order) {
            return [
                'id' => $order['id_order'],
                'collection' => Config::COLLECTION_ORDERS,
                'properties' => $order,
            ];
        }, $orders);

        return array_merge($orders, $orderDetails, $orderStatuses, $orderCartRules);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->orderRepository->getRemainingOrderCount($offset, $this->shopId);
    }

    /**
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $langId = (int) \Language::getIdByIso($langIso);
        $orders = $this->orderRepository->getOrdersIncremental($limit, $this->shopId, $objectIds);

        if (!is_array($orders) || empty($orders)) {
            return [];
        }

        $orderDetails = $this->getOrderDetails($orders);
        $orderStatuses = $this->getOrderStatuses($orders, $langId);
        $orderCartRules = $this->getOrderCartRules($orders);

        $this->castOrderValues($orders, (int) \Language::getIdByIso($langIso));

        $orders = array_map(function ($order) {
            return [
                'id' => $order['id_order'],
                'collection' => Config::COLLECTION_ORDERS,
                'properties' => $order,
            ];
        }, $orders);

        return array_merge($orders, $orderDetails, $orderStatuses, $orderCartRules);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->orderRepository->getQueryForDebug($offset, $limit, $this->shopId);
    }

    /**
     * @param array $orders
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function getOrderDetails(array $orders)
    {
        if (empty($orders)) {
            return [];
        }

        $orderIds = $this->arrayFormatter->formatValueArray($orders, 'id_order');

        $orderDetails = $this->orderDetailsRepository->getOrderDetails($orderIds, $this->shopId);

        if (!is_array($orderDetails) || empty($orderDetails)) {
            return [];
        }

        $this->castOrderDetailValues($orderDetails);

        $orderDetails = array_map(function ($orderDetail) {
            return [
                'id' => $orderDetail['id_order_detail'],
                'collection' => Config::COLLECTION_ORDER_DETAILS,
                'properties' => $orderDetail,
            ];
        }, $orderDetails);

        return $orderDetails;
    }

    /**
     * @param array $orders
     * @param int $langId
     *
     * @return array|array[]
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function getOrderStatuses(array $orders, $langId)
    {
        if (empty($orders)) {
            return [];
        }
        $orderIds = $this->arrayFormatter->formatValueArray($orders, 'id_order');
        $orderHistoryStatuses = $this->orderHistoryRepository->getOrderHistoryStatuses($orderIds, $langId);
        $orderHistoryStatuses = $this->castOrderStatuses($orderHistoryStatuses);

        return array_map(function ($orderHistoryStatus) {
            return [
                'id' => $orderHistoryStatus['id_order_history'],
                'collection' => Config::COLLECTION_ORDER_STATUS_HISTORY,
                'properties' => $orderHistoryStatus,
            ];
        }, $orderHistoryStatuses);
    }

    /**
     * @param array $orders
     *
     * @return array|array[]
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function getOrderCartRules(array $orders)
    {
        if (empty($orders)) {
            return [];
        }
        $orderIds = $this->arrayFormatter->formatValueArray($orders, 'id_order');
        $orderCartRules = $this->orderCartRuleRepository->getOrderCartRules($orderIds);
        $this->castOrderCartRulesValues($orderCartRules);

        return array_map(function ($orderCartRule) {
            return [
                'id' => $orderCartRule['id_order_cart_rule'],
                'collection' => Config::COLLECTION_ORDER_CART_RULES,
                'properties' => $orderCartRule,
            ];
        }, $orderCartRules);
    }

    /**
     * @param array $orders
     * @param int $langId
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function castOrderValues(array &$orders, int $langId)
    {
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
            $this->castAddressIsoCodes($order);
            unset($order['address_iso']);
        }
    }

    /**
     * @param array $orders
     * @param array $order
     * @param int $langId
     *
     * @return bool
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function castIsPaidValue(array $orders, array $order, int $langId)
    {
        $isPaid = $dateAdd = 0;
        $orderIds = $this->arrayFormatter->formatValueArray($orders, 'id_order');
        /** @var array $orderHistoryStatuses */
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
     * @param array $orderDetails
     *
     * @return void
     */
    private function castOrderDetailValues(array &$orderDetails)
    {
        foreach ($orderDetails as &$orderDetail) {
            $orderDetail['id_order_detail'] = (int) $orderDetail['id_order_detail'];
            $orderDetail['id_order'] = (int) $orderDetail['id_order'];
            $orderDetail['product_id'] = (int) $orderDetail['product_id'];
            $orderDetail['product_attribute_id'] = (int) $orderDetail['product_attribute_id'];
            $orderDetail['product_quantity'] = (int) $orderDetail['product_quantity'];
            $orderDetail['unit_price_tax_incl'] = (float) $orderDetail['unit_price_tax_incl'];
            $orderDetail['unit_price_tax_excl'] = (float) $orderDetail['unit_price_tax_excl'];
            $orderDetail['refund'] = (float) $orderDetail['refund'] > 0 ? -1 * (float) $orderDetail['refund'] : 0;
            $orderDetail['refund_tax_excl'] = (float) $orderDetail['refund_tax_excl'] > 0 ? -1 * (float) $orderDetail['refund_tax_excl'] : 0;
            $orderDetail['category'] = (int) $orderDetail['category'];
            $orderDetail['unique_product_id'] = "{$orderDetail['product_id']}-{$orderDetail['product_attribute_id']}-{$orderDetail['iso_code']}";
            $orderDetail['conversion_rate'] = (float) $orderDetail['conversion_rate'];
        }
    }

    private function castOrderStatuses(array &$orderStatuses): array
    {
        $castedOrderStatuses = [];
        foreach ($orderStatuses as $orderStatus) {
            $castedOrderStatus = [];
            $castedOrderStatus['id_order_state'] = (int) $orderStatus['id_order_state'];
            $castedOrderStatus['id_order'] = (int) $orderStatus['id_order'];
            $castedOrderStatus['id_order_history'] = (int) $orderStatus['id_order_history'];
            $castedOrderStatus['name'] = (string) $orderStatus['name'];
            $castedOrderStatus['template'] = (string) $orderStatus['template'];
            $castedOrderStatus['date_add'] = $orderStatus['date_add'];
            $castedOrderStatus['is_validated'] = (bool) $orderStatus['logable'];
            $castedOrderStatus['is_delivered'] = (bool) $orderStatus['delivery'];
            $castedOrderStatus['is_shipped'] = (bool) $orderStatus['shipped'];
            $castedOrderStatus['is_paid'] = (bool) $orderStatus['paid'];
            $castedOrderStatus['is_deleted'] = (bool) $orderStatus['deleted'];
            $castedOrderStatus['created_at'] = $castedOrderStatus['date_add'];
            $castedOrderStatus['updated_at'] = $castedOrderStatus['date_add'];
            $castedOrderStatuses[] = $castedOrderStatus;
        }

        return $castedOrderStatuses;
    }

    /**
     * @param array $orderDetail
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

    /**
     * @param array $orderCartRules
     *
     * @return void
     */
    private function castOrderCartRulesValues(array &$orderCartRules)
    {
        foreach ($orderCartRules as &$orderCartRule) {
            $orderCartRule['id_order_cart_rule'] = (int) $orderCartRule['id_order_cart_rule'];
            $orderCartRule['id_order'] = (int) $orderCartRule['id_order'];
            $orderCartRule['id_cart_rule'] = (int) $orderCartRule['id_cart_rule'];
            $orderCartRule['id_order_invoice'] = (int) $orderCartRule['id_order_invoice'];
            $orderCartRule['value'] = (float) $orderCartRule['value'];
            $orderCartRule['value_tax_excl'] = (float) $orderCartRule['value_tax_excl'];
            $orderCartRule['free_shipping'] = (bool) $orderCartRule['free_shipping'];
            $orderCartRule['deleted'] = isset($orderCartRule['deleted']) ? (bool) $orderCartRule['deleted'] : false;
        }
    }
}
