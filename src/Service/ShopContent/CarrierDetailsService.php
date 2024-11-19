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

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarrierDetailsService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var CarrierDetailRepository */
    private $carrierDetailRepository;

    public function __construct(CarrierDetailRepository $carrierDetailRepository)
    {
        $this->carrierDetailRepository = $carrierDetailRepository;
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

        $this->castCarrierDetails($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_CARRIER_DETAILS,
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
        $result = $this->carrierDetailRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCarrierDetails($result);
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
            $carrierDetail['id_carrier_detail'] = (string) $carrierDetail['id_range']; // same value as id_range
            $carrierDetail['shipping_method'] = (string) $carrierDetail['shipping_method'];
            $carrierDetail['delimiter1'] = (float) $carrierDetail['delimiter1'];
            $carrierDetail['delimiter2'] = (float) $carrierDetail['delimiter2'];
            $carrierDetail['country_ids'] = (string) $carrierDetail['country_ids'];
            $carrierDetail['state_ids'] = (string) $carrierDetail['state_ids'];
            $carrierDetail['price'] = (float) $carrierDetail['price'];
        }
    }
}
