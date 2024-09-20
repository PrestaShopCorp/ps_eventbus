<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ImageRepository;

class ImagesService implements ShopContentServiceInterface
{
    /** @var ImageRepository */
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
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
        $result = $this->imageRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castImages($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_image'],
                'collection' => Config::COLLECTION_IMAGES,
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
        $result = $this->imageRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castImages($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_image'],
                'collection' => Config::COLLECTION_IMAGES,
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
        return $this->imageRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $images
     *
     * @return void
     */
    private function castImages(&$images)
    {
        foreach ($images as &$image) {
            $image['id_image'] = (int) $image['id_image'];
            $image['id_product'] = (int) $image['id_product'];
            $image['id_lang'] = (int) $image['id_lang'];
            $image['id_shop'] = (int) $image['id_shop'];
            $image['position'] = (int) $image['position'];
            $image['cover'] = (bool) $image['cover'];
            $image['legend'] = (string) $image['legend'];
        }
    }
}
