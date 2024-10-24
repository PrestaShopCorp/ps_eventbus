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
use PrestaShop\Module\PsEventbus\Repository\TaxeRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarrierTaxesService extends ShopContentAbstractService implements ShopContentServiceInterface
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

        $carrierTaxes = [];

        foreach ($result as $carrierData) {
            $carrierTaxes = array_merge($carrierTaxes, $this->buildCarrierTaxes($carrierData));
        }

        $this->castCarrierTaxes($carrierTaxes);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'] . '-' . $item['id_zone'] . '-' . $item['id_range'],
                'collection' => Config::COLLECTION_CARRIER_TAXES,
                'properties' => $item,
            ];
        }, $carrierTaxes);
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
            $carrierTaxes = [];

            foreach ($result as $carrierData) {
                $carrierTaxes = array_merge($carrierTaxes, $this->buildCarrierTaxes($carrierData));
            }

            $this->castCarrierTaxes($carrierTaxes);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CARRIER_TAXES, 'id_carrier', $result, $upsertedContents, $deletedContents);
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
        $data = $this->getContentsForFull($offset, 50, $langIso);

        return count($data);
    }

    /**
     * @param array<mixed> $carrierTaxes
     *
     * @return void
     */
    private function castCarrierTaxes(&$carrierTaxes)
    {
        foreach ($carrierTaxes as &$carrierTaxe) {
            $carrierTaxe['id_reference'] = (string) $carrierTaxe['id_reference'];
            $carrierTaxe['id_zone'] = (string) $carrierTaxe['id_zone'];
            $carrierTaxe['id_range'] = (string) $carrierTaxe['id_range'];
            $carrierTaxe['id_carrier_tax'] = (string) $carrierTaxe['id_carrier_tax'];
            $carrierTaxe['country_ids'] = (string) $carrierTaxe['country_ids'];
            $carrierTaxe['state_ids'] = (string) $carrierTaxe['state_ids'];
            $carrierTaxe['tax_rate'] = (float) $carrierTaxe['tax_rate'];
        }
    }

    /**
     * Build a CarrierTaxes from Carrier
     *
     * @param array<mixed> $carrierData
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    private function buildCarrierTaxes($carrierData)
    {
        /** @var \Ps_eventbus $module */
        $module = \Module::getInstanceByName('ps_eventbus');

        /** @var TaxeRepository $taxeRepository */
        $taxeRepository = $module->getService('PrestaShop\Module\PsEventbus\Repository\TaxeRepository');

        $carrier = new \Carrier($carrierData['id_reference']);

        $deliveryPriceByRanges = CarriersService::getDeliveryPriceByRange($carrier);

        if (!$deliveryPriceByRanges) {
            return [];
        }

        $carrierTaxes = [];

        foreach ($deliveryPriceByRanges as $deliveryPriceByRange) {
            $range = CarriersService::getCarrierRange($deliveryPriceByRange);

            if (!$range) {
                continue;
            }

            foreach ($deliveryPriceByRange['zones'] as $zone) {
                $taxRulesGroupId = (int) $carrier->getIdTaxRulesGroup();

                /** @var array<mixed> $carrierTaxesByZone */
                $carrierTaxesByZone = $taxeRepository->getCarrierTaxesByZone($zone['id_zone'], $taxRulesGroupId, true);

                if (!$carrierTaxesByZone[0]['country_iso_code']) {
                    continue;
                }

                $carrierTaxesByZone = $carrierTaxesByZone[0];

                $carrierTaxe = [];

                $carrierTaxe['id_reference'] = $carrier->id_reference;
                $carrierTaxe['id_zone'] = $zone['id_zone'];
                $carrierTaxe['id_range'] = $range->id;
                $carrierTaxe['id_carrier_tax'] = $taxRulesGroupId;
                $carrierTaxe['country_id'] = $carrierTaxesByZone['country_iso_code'];
                $carrierTaxe['state_ids'] = $carrierTaxesByZone['state_iso_code'];
                $carrierTaxe['tax_rate'] = $carrierTaxesByZone['rate'];

                array_push($carrierTaxes, $carrierTaxe);
            }
        }

        return $carrierTaxes;
    }
}
