<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ImageTypeRepository;

class ImageTypesService implements ShopContentServiceInterface
{
    /** @var ImageTypeRepository */
    private $imageTypeRepository;

    public function __construct(ImageTypeRepository $imageTypeRepository)
    {
        $this->imageTypeRepository = $imageTypeRepository;
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
        $result = $this->imageTypeRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castImageTypes($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_image_type'],
                'collection' => Config::COLLECTION_IMAGE_TYPES,
                'properties' => $item,
            ];
        }, $result);
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
        $result = $this->imageTypeRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castImageTypes($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_image_type'],
                'collection' => Config::COLLECTION_IMAGE_TYPES,
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
        return $this->imageTypeRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $imageTypes
     *
     * @return void
     */
    private function castImageTypes(&$imageTypes)
    {
        foreach ($imageTypes as &$imageType) {
            $imageType['id_image_type'] = (int) $imageType['id_image_type'];
            $imageType['name'] = (string) $imageType['name'];
            $imageType['width'] = (int) $imageType['width'];
            $imageType['height'] = (int) $imageType['height'];
            $imageType['products'] = (bool) $imageType['products'];
            $imageType['categories'] = (bool) $imageType['categories'];
            $imageType['manufacturers'] = (bool) $imageType['manufacturers'];
            $imageType['suppliers'] = (bool) $imageType['suppliers'];
            $imageType['stores'] = (bool) $imageType['stores'];
        }
    }
}
