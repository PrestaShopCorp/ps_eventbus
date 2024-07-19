<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\ImageTypeDecorator;
use PrestaShop\Module\PsEventbus\Repository\ImageTypeRepository;

class ImageTypeDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ImageTypeRepository
     */
    private $imageTypeRepository;
    /**
     * @var ImageTypeDecorator
     */
    private $imageTypeDecorator;

    public function __construct(ImageTypeRepository $imageTypeRepository, ImageTypeDecorator $imageTypeDecorator)
    {
        $this->imageTypeRepository = $imageTypeRepository;
        $this->imageTypeDecorator = $imageTypeDecorator;
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
        $imageTypes = $this->imageTypeRepository->getImageTypes($offset, $limit);

        if (!is_array($imageTypes)) {
            return [];
        }

        $this->imageTypeDecorator->decorateImageTypes($imageTypes);

        return array_map(function ($imageType) {
            return [
                'id' => "{$imageType['id_image_type']}",
                'collection' => Config::COLLECTION_IMAGE_TYPES,
                'properties' => $imageType,
            ];
        }, $imageTypes);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->imageTypeRepository->getRemainingImageTypesCount($offset);
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
        $imageTypes = $this->imageTypeRepository->getImageTypesIncremental($limit, $objectIds);

        if (!is_array($imageTypes)) {
            return [];
        }

        $this->imageTypeDecorator->decorateImageTypes($imageTypes);

        return array_map(function ($imageType) {
            return [
                'id' => "{$imageType['id_image_type']}",
                'collection' => Config::COLLECTION_IMAGE_TYPES,
                'properties' => $imageType,
            ];
        }, $imageTypes);
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
        return $this->imageTypeRepository->getQueryForDebug($offset, $limit);
    }
}
