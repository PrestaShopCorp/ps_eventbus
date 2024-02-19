<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ImageTypeRepository
{
    /**
     * @var \PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\DbQuery
     */
    private function getBaseQuery()
    {
        $query = new \PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

        $query->from('image_type', 'it');

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
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
     * @throws \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
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
     * @throws \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \PrestaShop\PrestaShop\Adapter\Entity\DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('it.id_image_type');
        $query->select('it.name');
        $query->select('it.width');
        $query->select('it.height');
        $query->select('it.products');
        $query->select('it.categories');
        $query->select('it.manufacturers');
        $query->select('it.suppliers');
        $query->select('it.stores');
    }
}
