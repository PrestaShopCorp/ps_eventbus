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
use PrestaShop\Module\PsEventbus\Repository\CategoryRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CategoriesService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        $result = $this->categoryRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCategories($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_CATEGORIES,
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
        $result = $this->categoryRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCategories($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CATEGORIES, $result, $deletedContents);
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
        return $this->categoryRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param int $topCategoryId
     * @param int $langId
     * @param int $shopId
     *
     * @return array<mixed>
     */
    public function getCategoryPaths($topCategoryId, $langId, $shopId)
    {
        if ((int) $topCategoryId === 0) {
            return [
                'category_path' => '',
                'category_id_path' => '',
            ];
        }

        $categories = [];

        try {
            $categoriesWithParentsInfo = $this->categoryRepository->getCategoriesWithParentInfo($langId, $shopId);
        } catch (\PrestaShopDatabaseException $e) {
            return [
                'category_path' => '',
                'category_id_path' => '',
            ];
        }

        $this->buildCategoryPaths($categoriesWithParentsInfo, $topCategoryId, $categories);

        $categories = array_reverse($categories);

        return [
            'category_path' => implode(' > ', array_map(function ($category) {
                return $category['name'];
            }, $categories)),
            'category_id_path' => implode(' > ', array_map(function ($category) {
                return $category['id_category'];
            }, $categories)),
        ];
    }

    /**
     * @param array<mixed> $categoriesWithParentsInfo
     * @param int $currentCategoryId
     * @param array<mixed> $categories
     *
     * @return void
     */
    private function buildCategoryPaths($categoriesWithParentsInfo, $currentCategoryId, &$categories)
    {
        foreach ($categoriesWithParentsInfo as $category) {
            if ($category['id_category'] == $currentCategoryId) {
                $categories[] = $category;
                $this->buildCategoryPaths($categoriesWithParentsInfo, $category['id_parent'], $categories);
            }
        }
    }

    /**
     * @param array<mixed> $categories
     *
     * @return void
     */
    private function castCategories(&$categories)
    {
        foreach ($categories as &$category) {
            $category['id_category'] = (int) $category['id_category'];
            $category['id_parent'] = (int) $category['id_parent'];
            $category['description'] = base64_encode($category['description']);
        }
    }
}
