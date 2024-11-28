<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CategoryRepository
{
    /**
     * @var \Db
     */
    private $db;

    /**
     * @var array<mixed>
     */
    private $categoryLangCache;

    /**
     * @var \Context
     */
    private $context;

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;
    }

    /**
     * @param string $langIso
     *
     * @return \DbQuery
     */
    private function getBaseQuery($langIso)
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new \DbQuery();
        $query->from('category_shop', 'cs')
            ->innerJoin('category', 'c', 'cs.id_category = c.id_category')
            ->leftJoin('category_lang', 'cl', 'cl.id_category = cs.id_category')
            ->leftJoin('lang', 'l', 'l.id_lang = cl.id_lang')
            ->where('cs.id_shop = ' . $shopId)
            ->where('cl.id_shop = cs.id_shop')
            ->where('l.iso_code = "' . pSQL($langIso) . '"');

        return $query;
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
            $categoriesWithParentsInfo = $this->getCategoriesWithParentInfo($langId, $shopId);
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
     * @param int $langId
     * @param int $shopId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCategoriesWithParentInfo($langId, $shopId)
    {
        if (!isset($this->categoryLangCache[$langId])) {
            $query = new \DbQuery();

            $query->select('c.id_category, cl.name, c.id_parent')
                ->from('category', 'c')
                ->leftJoin(
                    'category_lang',
                    'cl',
                    'cl.id_category = c.id_category AND cl.id_shop = ' . (int) $shopId
                )
                ->where('cl.id_lang = ' . (int) $langId)
                ->orderBy('cl.id_category');

            $result = $this->db->executeS($query);

            if (is_array($result)) {
                $this->categoryLangCache[$langId] = $result;
            } else {
                throw new \PrestaShopDatabaseException('No categories found');
            }
        }

        return $this->categoryLangCache[$langId];
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCategories($offset, $limit, $langIso)
    {
        $query = $this->getBaseQuery($langIso);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingCategoriesCount($offset, $langIso)
    {
        $query = $this->getBaseQuery($langIso)
            ->select('(COUNT(cs.id_category) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $categoryIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCategoriesIncremental($limit, $langIso, $categoryIds)
    {
        $query = $this->getBaseQuery($langIso);

        $this->addSelectParameters($query);

        $query->where('c.id_category IN(' . implode(',', array_map('intval', $categoryIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        $query = $this->getBaseQuery($langIso);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('CONCAT(cs.id_category, "-", l.iso_code) as unique_category_id, cs.id_category');
        $query->select('c.id_parent, cl.name, cl.description, cl.link_rewrite, cl.meta_title, cl.meta_description');
        $query->select('l.iso_code, c.date_add as created_at, c.date_upd as updated_at');

        // REMOVED HERE: https://github.com/PrestaShop/PrestaShop/commit/f37a8f61017654bae160b528a1a2eaf49edbdac0
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '9.0', '<')) {
            $query->select('cl.meta_keywords');
        }
    }
}
