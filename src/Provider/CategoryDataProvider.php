<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\CategoryDecorator;
use PrestaShop\Module\PsEventbus\Repository\CategoryRepository;

class CategoryDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var CategoryDecorator
     */
    private $categoryDecorator;

    public function __construct(CategoryRepository $categoryRepository, CategoryDecorator $categoryDecorator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryDecorator = $categoryDecorator;
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
        $categories = $this->categoryRepository->getCategories($offset, $limit, $langIso);

        if (!is_array($categories)) {
            return [];
        }

        $this->categoryDecorator->decorateCategories($categories);

        return array_map(function ($category) {
            return [
                'id' => "{$category['id_category']}-{$category['iso_code']}",
                'collection' => Config::COLLECTION_CATEGORIES,
                'properties' => $category,
            ];
        }, $categories);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->categoryRepository->getRemainingCategoriesCount($offset, $langIso);
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
        $categories = $this->categoryRepository->getCategoriesIncremental($limit, $langIso, $objectIds);

        if (!is_array($categories)) {
            return [];
        }

        $this->categoryDecorator->decorateCategories($categories);

        return array_map(function ($category) {
            return [
                'id' => "{$category['id_category']}-{$category['iso_code']}",
                'collection' => Config::COLLECTION_CATEGORIES,
                'properties' => $category,
            ];
        }, $categories);
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
        return $this->categoryRepository->getQueryForDebug($offset, $limit, $langIso);
    }
}
