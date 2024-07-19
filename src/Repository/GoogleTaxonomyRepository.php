<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class GoogleTaxonomyRepository
{
    /**
     * @var \Db
     */
    private $db;

    public function __construct()
    {
        $this->db = \Db::getInstance();
    }

    /**
     * @param int $shopId
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId)
    {
        $dbQuery = new \DbQuery();

        $dbQuery->from('fb_category_match', 'cm')
            ->where('cm.id_shop = ' . (int) $shopId);

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $shopId
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getTaxonomyCategories($offset, $limit, $shopId)
    {
        $dbQuery = $this->getBaseQuery($shopId);

        $dbQuery->select('cm.id_category, cm.google_category_id')
            ->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param int $shopId
     *
     * @return int
     */
    public function getRemainingTaxonomyRepositories($offset, $shopId)
    {
        $dbQuery = $this->getBaseQuery($shopId);

        $dbQuery->select('(COUNT(cm.id_category) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($dbQuery);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $shopId
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $shopId)
    {
        $dbQuery = $this->getBaseQuery($shopId);

        $dbQuery->select('cm.id_category, cm.google_category_id')
            ->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }
}
