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

if (!defined('_PS_VERSION_')) {
    exit;
}

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\ManufacturerDecorator;
use PrestaShop\Module\PsEventbus\Repository\ManufacturerRepository;

class ManufacturerDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ManufacturerRepository
     */
    private $manufacturerRepository;

    /**
     * @var ManufacturerDecorator
     */
    private $manufacturerDecorator;

    public function __construct(ManufacturerRepository $manufacturerRepository, ManufacturerDecorator $manufacturerDecorator)
    {
        $this->manufacturerRepository = $manufacturerRepository;
        $this->manufacturerDecorator = $manufacturerDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $manufacturers = $this->manufacturerRepository->getManufacturers($offset, $limit, $langIso);

        if (!is_array($manufacturers)) {
            return [];
        }
        $this->manufacturerDecorator->decorateManufacturers($manufacturers);

        return array_map(function ($manufacturer) {
            return [
                'id' => $manufacturer['id_manufacturer'],
                'collection' => Config::COLLECTION_MANUFACTURERS,
                'properties' => $manufacturer,
            ];
        }, $manufacturers);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->manufacturerRepository->getRemainingManufacturersCount($offset, $langIso);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $objectIds
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $manufacturers = $this->manufacturerRepository->getManufacturersIncremental($limit, $langIso, $objectIds);

        if (!is_array($manufacturers)) {
            return [];
        }
        $this->manufacturerDecorator->decorateManufacturers($manufacturers);

        return array_map(function ($manufacturer) {
            return [
                'id' => $manufacturer['id_manufacturer'],
                'collection' => Config::COLLECTION_MANUFACTURERS,
                'properties' => $manufacturer,
            ];
        }, $manufacturers);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->manufacturerRepository->getQueryForDebug($offset, $limit, $langIso);
    }
}
