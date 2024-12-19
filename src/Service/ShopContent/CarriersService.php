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
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarriersService extends ShopContentAbstractService implements ShopContentServiceInterface
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
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_CARRIERS,
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
        $result = $this->carrierRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCarriers($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CARRIERS, $result, $deletedContents);
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
     * @param \Carrier $carrier
     * @param array<mixed> $delivery
     *
     * @return false|\RangeWeight|\RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public static function generateRange($carrier, $delivery)
    {
        $rangeTable = $carrier->getRangeTable();

        if ($rangeTable === 'range_weight') {
            return new \RangeWeight($delivery['id_range_weight']);
        }

        if ($rangeTable === 'range_price') {
            return new \RangePrice($delivery['id_range_price']);
        }

        return false;
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
            $carrier['disable_carrier_when_out_of_range'] = (bool) $carrier['disable_carrier_when_out_of_range'];
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
