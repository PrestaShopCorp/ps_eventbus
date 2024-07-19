<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ImageTypeRepository
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
     * @return \DbQuery
     */
    private function getBaseQuery()
    {
        $dbQuery = new \DbQuery();

        $dbQuery->from('image_type', 'it');

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getImageTypes($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingImageTypesCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(it.id_image_type) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $imageTypeIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getImageTypesIncremental($limit, $imageTypeIds)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('it.id_image_type IN(' . implode(',', array_map('intval', $imageTypeIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('it.id_image_type');
        $dbQuery->select('it.name');
        $dbQuery->select('it.width');
        $dbQuery->select('it.height');
        $dbQuery->select('it.products');
        $dbQuery->select('it.categories');
        $dbQuery->select('it.manufacturers');
        $dbQuery->select('it.suppliers');
        $dbQuery->select('it.stores');
    }
}
