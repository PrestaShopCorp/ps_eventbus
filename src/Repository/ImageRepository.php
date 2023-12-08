<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ImageRepository
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

        $query->from('image', 'i')
            ->leftJoin('image_lang', 'il', 'il.id_image = i.id_image')
            ->leftJoin('image_shop', 'is', 'is.id_image = i.id_image');

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
    public function getImages($offset, $limit)
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
    public function getRemainingImagesCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(it.id_image) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $imageIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getImagesIncremental($limit, $imageIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('it.id_image IN(' . implode(',', array_map('intval', $imageIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('
            it.id_image,
            it.id_product,
            it.id_lang,
            it.id_shop,
            it.position,
            it.cover,
            it.legend
        ');
    }
}
