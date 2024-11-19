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
use PrestaShop\Module\PsEventbus\Repository\CarrierTaxeRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CarrierTaxesService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var CarrierTaxeRepository */
    private $carrierTaxeRepository;

    public function __construct(CarrierTaxeRepository $carrierTaxeRepository)
    {
        $this->carrierTaxeRepository = $carrierTaxeRepository;
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
        $result = $this->carrierTaxeRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCarrierTaxes($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_CARRIER_TAXES,
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
        $result = $this->carrierTaxeRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCarrierTaxes($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CARRIER_TAXES, $result, $deletedContents);
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
        return $this->carrierTaxeRepository->countFullSyncContentLeft($offset, $limit, $langIso);
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
            $carrierTaxe['country_id'] = (string) $carrierTaxe['country_id'];
            $carrierTaxe['state_ids'] = (string) $carrierTaxe['state_ids'];
            $carrierTaxe['tax_rate'] = (float) $carrierTaxe['tax_rate'];
        }
    }
}
