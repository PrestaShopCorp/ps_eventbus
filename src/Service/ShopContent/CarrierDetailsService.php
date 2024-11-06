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
use PrestaShop\Module\PsEventbus\Repository\CarrierDetailRepository;
use PrestaShop\Module\PsEventbus\Repository\CountryRepository;
use PrestaShop\Module\PsEventbus\Repository\StateRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarrierDetailsService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var CarrierDetailRepository */
    private $carrierDetailRepository;

    /** @var CountryRepository */
    private $countryRepository;

    /** @var StateRepository */
    private $stateRepository;

    public function __construct(
        CarrierDetailRepository $carrierDetailRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository
    ) {
        $this->carrierDetailRepository = $carrierDetailRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
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
        $result = $this->carrierDetailRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $carrierDetails = [];

        foreach ($result as $delivery) {
            $carrierDetails[] = $this->buildCarrierDetail($delivery);
        }

        $this->castCarrierDetails($carrierDetails);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
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
        $result = $this->carrierDetailRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $carrierDetails = [];

            foreach ($result as $delivery) {
                $carrierDetails[] = $this->buildCarrierDetail($delivery);
            }

            $this->castCarrierDetails($carrierDetails);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CARRIER_DETAILS, $result, $deletedContents);
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
        return $this->carrierDetailRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * Build a CarrierDetail from delivery data
     *
     * @param array<mixed> $delivery
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    private function buildCarrierDetail($delivery)
    {
        $carrier = new \Carrier($delivery['id_carrier']);
        $range = CarriersService::generateRange($carrier, $delivery);

        /** @var array<mixed> $countryIsoCodes */
        $countryIsoCodes = $this->countryRepository->getCountryIsoCodesByZoneId($delivery['id_zone'], true);

        /** @var array<mixed> $stateIsoCodes */
        $stateIsoCodes = $this->stateRepository->getStateIsoCodesByZoneId($delivery['id_zone'], true);

        return [
            'id_reference' => $carrier->id_reference,
            'id_zone' => $delivery['id_zone'],
            'id_range' => $range->id,
            'id_carrier_detail' => $range->id,
            'shipping_method' => $carrier->getRangeTable(),
            'delimiter1' => $range->delimiter1,
            'delimiter2' => $range->delimiter2,
            'country_ids' => implode(',', $countryIsoCodes),
            'state_ids' => implode(',', $stateIsoCodes),
            'price' => $delivery['price'],
        ];
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
}
