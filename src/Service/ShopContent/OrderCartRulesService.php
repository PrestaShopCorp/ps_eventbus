<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ShopContentServiceInterface;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\OrderCartRuleRepository;

class OrderCartRulesService implements ShopContentServiceInterface
{
    /** @var OrderCartRuleRepository */
    private $orderCartRuleRepository;

    public function __construct(
        OrderCartRuleRepository $orderCartRuleRepository,
    ) {
        $this->orderCartRuleRepository = $orderCartRuleRepository;
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
        $orders = $this->orderCartRuleRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($orders)) {
            return [];
        }

        $this->castOrderCartRules($orders, $langIso);

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
        $orders = $this->orderCartRuleRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($orders)) {
            return [];
        }

        $this->castOrderCartRules($orders, $langIso);

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
        return (int) $this->orderCartRuleRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }

    /**
     * @param array<mixed> $cartRules
     * @param string $langIso
     *
     * @return void
     */
    public function castOrderCartRules(&$cartRules, $langIso)
    {
        foreach ($cartRules as &$cartRule) {
            $cartRule['id_cart_rule'] = (int) $cartRule['id_cart_rule'];
            $cartRule['id_customer'] = (int) $cartRule['id_customer'];
            $cartRule['quantity'] = (int) $cartRule['quantity'];
            $cartRule['quantity_per_user'] = (int) $cartRule['quantity_per_user'];
            $cartRule['priority'] = (int) $cartRule['priority'];
            $cartRule['partial_use'] = (bool) $cartRule['partial_use'];
            $cartRule['minimum_amount'] = (float) $cartRule['minimum_amount'];
            $cartRule['minimum_amount_tax'] = (bool) $cartRule['minimum_amount_tax'];
            $cartRule['minimum_amount_currency'] = (int) $cartRule['minimum_amount_currency'];
            $cartRule['minimum_amount_shipping'] = (bool) $cartRule['minimum_amount_shipping'];
            $cartRule['country_restriction'] = (bool) $cartRule['country_restriction'];
            $cartRule['carrier_restriction'] = (bool) $cartRule['carrier_restriction'];
            $cartRule['group_restriction'] = (bool) $cartRule['group_restriction'];
            $cartRule['cart_rule_restriction'] = (bool) $cartRule['cart_rule_restriction'];
            $cartRule['product_restriction'] = (bool) $cartRule['product_restriction'];
            $cartRule['shop_restriction'] = (bool) $cartRule['shop_restriction'];
            $cartRule['free_shipping'] = (bool) $cartRule['free_shipping'];
            $cartRule['reduction_percent'] = (float) $cartRule['reduction_percent'];
            $cartRule['reduction_amount'] = (float) $cartRule['reduction_amount'];
            $cartRule['reduction_tax'] = (bool) $cartRule['reduction_tax'];
            $cartRule['reduction_currency'] = (int) $cartRule['reduction_currency'];
            $cartRule['reduction_product'] = (int) $cartRule['reduction_product'];
            $cartRule['reduction_exclude_special'] = (bool) $cartRule['reduction_exclude_special'];
            $cartRule['gift_product'] = (int) $cartRule['gift_product'];
            $cartRule['gift_product_attribute'] = (int) $cartRule['gift_product_attribute'];
            $cartRule['highlight'] = (bool) $cartRule['highlight'];
            $cartRule['active'] = (bool) $cartRule['active'];
        }
    }
}
