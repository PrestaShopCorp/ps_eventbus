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
use PrestaShop\Module\PsEventbus\Repository\CountryRepository;
use PrestaShop\Module\PsEventbus\Repository\StateRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarrierDetailsService extends ShopContentAbstractService implements ShopContentServiceInterface
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

        $carrierDetails = [];

        foreach ($result as $carrierData) {
            $carrierDetails = array_merge($carrierDetails, $this->buildCarrierDetails($carrierData));
        }

        $this->castCarrierDetails($carrierDetails);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_ADD,
                'collection' => Config::COLLECTION_CARRIER_DETAILS,
                'properties' => $item,
            ];
        }, $carrierDetails);
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
            $carrierDetails = [];

            foreach ($result as $carrierData) {
                $carrierDetails = array_merge($carrierDetails, $this->buildCarrierDetails($carrierData));
            }

            $this->castCarrierDetails($carrierDetails);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CARRIER_DETAILS, 'id_carrier', $result, $upsertedContents, $deletedContents);
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
     * @param array<mixed> $carrierDetails
     *
     * @return void
     */
    private function castCarrierDetails(&$carrierDetails)
    {
        foreach ($carrierDetails as &$carrierDetail) {
            $carrierDetail['id_reference'] = (string) $carrierDetail['id_reference'];
            $carrierDetail['id_zone'] = (string) $carrierDetail['id_zone'];
            $carrierDetail['id_range'] = (string) $carrierDetail['id_range'];
            $carrierDetail['id_carrier_detail'] = (string) $carrierDetail['id_carrier_detail'];
            $carrierDetail['shipping_method'] = (string) $carrierDetail['shipping_method'];
            $carrierDetail['delimiter1'] = (float) $carrierDetail['delimiter1'];
            $carrierDetail['delimiter2'] = (float) $carrierDetail['delimiter2'];
            $carrierDetail['country_ids'] = (string) $carrierDetail['country_ids'];
            $carrierDetail['state_ids'] = (string) $carrierDetail['state_ids'];
            $carrierDetail['price'] = (float) $carrierDetail['price'];
        }
    }

    /**
     * Build a CarrierDetail from Carrier data
     *
     * @param array<mixed> $carrierData
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    private function buildCarrierDetails($carrierData)
    {
        /** @var \Ps_eventbus $module */
        $module = \Module::getInstanceByName('ps_eventbus');

        /** @var CountryRepository $countryRepository */
        $countryRepository = $module->getService('PrestaShop\Module\PsEventbus\Repository\CountryRepository');

        /** @var StateRepository $stateRepository */
        $stateRepository = $module->getService('PrestaShop\Module\PsEventbus\Repository\StateRepository');

        $carrier = new \Carrier($carrierData['id_reference']);

        $deliveryPriceByRanges = CarriersService::getDeliveryPriceByRange($carrier);

        if (!$deliveryPriceByRanges) {
            return [];
        }

        $carrierDetails = [];

        foreach ($deliveryPriceByRanges as $deliveryPriceByRange) {
            $range = CarriersService::getCarrierRange($deliveryPriceByRange);

            if (!$range) {
                continue;
            }

            foreach ($deliveryPriceByRange['zones'] as $zone) {
                /** @var array<mixed> $countryIsoCodes */
                $countryIsoCodes = $countryRepository->getCountyIsoCodesByZoneId($zone['id_zone'], true);

                /** @var array<mixed> $stateIsoCodes */
                $stateIsoCodes = $stateRepository->getStateIsoCodesByZoneId($zone['id_zone'], true);

                $carrierDetail = [];
                $carrierDetail['id_reference'] = $carrier->id_reference;
                $carrierDetail['id_zone'] = $zone['id_zone'];
                $carrierDetail['id_range'] = $range->id;
                $carrierDetail['id_carrier_detail'] = $range->id;
                $carrierDetail['shipping_method'] = $carrier->getRangeTable();
                $carrierDetail['delimiter1'] = $range->delimiter1;
                $carrierDetail['delimiter2'] = $range->delimiter2;
                $carrierDetail['country_ids'] = implode(',', $countryIsoCodes);
                $carrierDetail['state_ids'] = implode(',', $stateIsoCodes);
                $carrierDetail['price'] = $zone['price'];

                array_push($carrierDetails, $carrierDetail);
            }
        }

        return $carrierDetails;
    }
}
