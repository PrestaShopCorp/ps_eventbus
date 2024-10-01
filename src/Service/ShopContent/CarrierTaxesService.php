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
use PrestaShop\Module\PsEventbus\Helper\CarrierHelper;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarrierTaxesService implements ShopContentServiceInterface
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
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->carrierRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $carrierTaxes = [];

        foreach ($result as $carrierData) {
            $carrierTaxes = array_merge($carrierTaxes, CarrierHelper::buildCarrierTaxes($carrierData));
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
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->carrierRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $carrierTaxes = [];

        foreach ($result as $carrierData) {
            $carrierTaxes = array_merge($carrierTaxes, CarrierHelper::buildCarrierDetails($carrierData));
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
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        $data = $this->getContentsForFull($offset, 50, $langIso, false);

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
}
