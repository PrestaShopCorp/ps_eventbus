<?php

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
