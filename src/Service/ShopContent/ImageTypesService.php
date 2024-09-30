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
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ImageTypeRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

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