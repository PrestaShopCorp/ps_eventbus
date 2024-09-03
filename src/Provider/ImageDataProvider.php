<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\ImageDecorator;
use PrestaShop\Module\PsEventbus\Repository\ImageRepository;

class ImageDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var ImageDecorator
     */
    private $imageDecorator;

    public function __construct(ImageRepository $imageRepository, ImageDecorator $imageDecorator)
    {
        $this->imageRepository = $imageRepository;
        $this->imageDecorator = $imageDecorator;
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
        $images = $this->imageRepository->getImages($offset, $limit);

        if (!is_array($images)) {
            return [];
        }

        $this->imageDecorator->decorateImages($images);

        return array_map(function ($image) {
            return [
                'id' => "{$image['id_image']}",
                'collection' => Config::COLLECTION_IMAGES,
                'properties' => $image,
            ];
        }, $images);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->imageRepository->getRemainingImagesCount($offset);
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
        $images = $this->imageRepository->getImagesIncremental($limit, $objectIds);

        if (!is_array($images)) {
            return [];
        }

        $this->imageDecorator->decorateImages($images);

        return array_map(function ($image) {
            return [
                'id' => "{$image['id_image']}",
                'collection' => Config::COLLECTION_IMAGES,
                'properties' => $image,
            ];
        }, $images);
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
        return $this->imageRepository->getQueryForDebug($offset, $limit);
    }
}
