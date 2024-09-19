<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CategoryRepository;

class CategoriesService implements ShopContentServiceInterface
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
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->categoryRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCategories($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => "{$item['id_category']}-{$item['iso_code']}",
                'collection' => Config::COLLECTION_CATEGORIES,
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
        $result = $this->categoryRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCategories($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => "{$item['id_category']}-{$item['iso_code']}",
                'collection' => Config::COLLECTION_CATEGORIES,
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
     * @param string $langIso
     *
     * @return void
     */
    private function castCategories(&$categories, $langIso)
    {
        foreach ($categories as &$category) {
            $category['id_category'] = (int) $category['id_category'];
            $category['id_parent'] = (int) $category['id_parent'];
            $category['description'] = base64_encode($category['description']);
        }
    }
}
