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
use PrestaShop\Module\PsEventbus\Repository\ManufacturerRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ManufacturersService implements ShopContentServiceInterface
{
    /** @var ManufacturerRepository */
    private $manufacturerRepository;

    public function __construct(ManufacturerRepository $manufacturerRepository)
    {
        $this->manufacturerRepository = $manufacturerRepository;
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
        $result = $this->manufacturerRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castManufacturers($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_manufacturer'],
                'collection' => Config::COLLECTION_MANUFACTURERS,
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
        $result = $this->manufacturerRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castManufacturers($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_manufacturer'],
                'collection' => Config::COLLECTION_MANUFACTURERS,
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
        return $this->manufacturerRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $manufacturers
     *
     * @return void
     */
    private function castManufacturers(&$manufacturers)
    {
        foreach ($manufacturers as &$manufacturer) {
            $manufacturer['id_manufacturer'] = (int) $manufacturer['id_manufacturer'];
            $manufacturer['active'] = (bool) $manufacturer['active'];
            $manufacturer['id_lang'] = (int) $manufacturer['id_lang'];
            $manufacturer['id_shop'] = (int) $manufacturer['id_shop'];
            $manufacturer['created_at'] = (string) $manufacturer['created_at'];
            $manufacturer['updated_at'] = (string) $manufacturer['updated_at'];
        }
    }
}
