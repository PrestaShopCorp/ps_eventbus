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
use PrestaShop\Module\PsEventbus\Repository\CustomProductCarrierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CustomProductCarriersService implements ShopContentServiceInterface
{
    /** @var CustomProductCarrierRepository */
    private $customProductCarrierRepository;

    public function __construct(CustomProductCarrierRepository $customProductCarrierRepository)
    {
        $this->customProductCarrierRepository = $customProductCarrierRepository;
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
        $result = $this->customProductCarrierRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        return array_map(function ($item) {
            return [
                'id' => $item['id_product'] . '-' . $item['id_carrier_reference'],
                'collection' => Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
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
        $result = $this->customProductCarrierRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

        if (empty($result)) {
            return [];
        }

        return array_map(function ($item) {
            return [
                'id' => $item['id_product'] . '-' . $item['id_carrier_reference'],
                'collection' => Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
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
        return $this->customProductCarrierRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }
}
