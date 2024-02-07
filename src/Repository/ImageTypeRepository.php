<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ImageTypeRepository
{
    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return \DbQuery
     */
    private function getBaseQuery()
    {
        $query = new \DbQuery();

        $query->from('image_type', 'it');

        return $query;
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
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
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
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('it.id_image_type IN(' . implode(',', array_map('intval', $imageTypeIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
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
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return [
            'query' => $query->getQuery(),
            'queryStringified' => $queryStringified,
        ];
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('
            it.id_image_type,
            it.name,
            it.width,
            it.height,
            it.products,
            it.categories,
            it.manufacturers,
            it.suppliers,
            it.stores
        ');
    }
}
