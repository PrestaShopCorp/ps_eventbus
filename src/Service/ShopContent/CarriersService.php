<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarriersService implements ShopContentServiceInterface
{
    /** @var CarrierRepository */
    private $carrierRepository;

    public function __construct(CarrierRepository $carrierRepository)
    {
        $this->carrierRepository = $carrierRepository;
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
        $result = $this->carrierRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCarriers($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'],
                'collection' => Config::COLLECTION_CARRIERS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso)
    {
        $result = $this->carrierRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCarriers($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'],
                'collection' => Config::COLLECTION_CARRIERS,
                'properties' => $item,
            ];
        }, $result);
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
        return $this->carrierRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $deliveryPriceByRange
     *
     * @return false|\RangeWeight|\RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public static function getCarrierRange($deliveryPriceByRange)
    {
        if (isset($deliveryPriceByRange['id_range_weight'])) {
            return new \RangeWeight($deliveryPriceByRange['id_range_weight']);
        }
        if (isset($deliveryPriceByRange['id_range_price'])) {
            return new \RangePrice($deliveryPriceByRange['id_range_price']);
        }

        return false;
    }

    /**
     * @param \Carrier $carrierObj
     *
     * @return array<mixed>|false
     */
    public static function getDeliveryPriceByRange(\Carrier $carrierObj)
    {
        $rangeTable = $carrierObj->getRangeTable();

        switch ($rangeTable) {
            case 'range_weight':
                return CarriersService::getCarrierByWeightRange($carrierObj, 'range_weight');
            case 'range_price':
                return CarriersService::getCarrierByPriceRange($carrierObj, 'range_price');
            default:
                return false;
        }
    }

    /**
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array<mixed>
     */
    public static function getCarrierByWeightRange(\Carrier $carrierObj, $rangeTable)
    {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

        $filteredRanges = [];

        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_weight']]['id_range_weight'] = $range['id_range_weight'];
            $filteredRanges[$range['id_range_weight']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_weight']]['zones'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_weight']]['zones'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
    }

    /**
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array<mixed>
     */
    public static function getCarrierByPriceRange(\Carrier $carrierObj, $rangeTable)
    {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

        $filteredRanges = [];

        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_price']]['id_range_price'] = $range['id_range_price'];
            $filteredRanges[$range['id_range_price']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_price']]['zones'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_price']]['zones'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
    }

    /**
     * @param array<mixed> $carriers
     *
     * @return void
     */
    private function castCarriers(&$carriers)
    {
        $context = \Context::getContext();

        if ($context == null) {
            throw new \PrestaShopException('Context is null');
        }

        $currency = new \Currency((int) \Configuration::get('PS_CURRENCY_DEFAULT'));
        $freeShippingStartsAtPrice = (float) \Configuration::get('PS_SHIPPING_FREE_PRICE');
        $freeShippingStartsAtWeight = (float) \Configuration::get('PS_SHIPPING_FREE_WEIGHT');

        /** @var string $psWeightUnit */
        $psWeightUnit = \Configuration::get('PS_WEIGHT_UNIT');

        foreach ($carriers as &$carrier) {
            $carrierTaxesRatesGroupId = \Carrier::getIdTaxRulesGroupByIdCarrier((int) $carrier['id_carrier'], \Context::getContext());

            $shippingHandling = 0.0;

            if ($carrier['shipping_handling']) {
                $shippingHandling = (float) \Configuration::get('PS_SHIPPING_HANDLING');
            }

            $carrier['id_carrier'] = (string) $carrier['id_carrier'];
            $carrier['id_reference'] = (string) $carrier['id_reference'];
            $carrier['name'] = (string) $carrier['name'];
            $carrier['carrier_taxes_rates_group_id'] = (string) $carrierTaxesRatesGroupId;
            $carrier['url'] = (string) $carrier['url'];
            $carrier['active'] = (bool) $carrier['active'];
            $carrier['deleted'] = (bool) $carrier['deleted'];
            $carrier['shipping_handling'] = (float) $shippingHandling;
            $carrier['free_shipping_starts_at_price'] = (float) $freeShippingStartsAtPrice;
            $carrier['free_shipping_starts_at_weight'] = (float) $freeShippingStartsAtWeight;
            $carrier['disable_carrier_when_out_of_range'] = (bool) $carrier['range_behavior'];
            $carrier['is_module'] = (bool) $carrier['is_module'];
            $carrier['is_free'] = (bool) $carrier['is_free'];
            $carrier['shipping_external'] = (bool) $carrier['shipping_external'];
            $carrier['need_range'] = (bool) $carrier['need_range'];
            $carrier['external_module_name'] = (string) $carrier['external_module_name'];
            $carrier['max_width'] = (float) $carrier['max_width'];
            $carrier['max_height'] = (float) $carrier['max_height'];
            $carrier['max_depth'] = (float) $carrier['max_depth'];
            $carrier['max_weight'] = (float) $carrier['max_weight'];
            $carrier['grade'] = (int) $carrier['grade'];
            $carrier['delay'] = (string) $carrier['delay'];
            $carrier['currency'] = (string) $currency->iso_code;
            $carrier['weight_unit'] = (string) $psWeightUnit;
        }
    }
}
