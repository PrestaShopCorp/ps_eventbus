<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ImageRepository
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

        $dbQuery->from('image', 'i')
            ->leftJoin('image_lang', 'il', 'il.id_image = i.id_image')
            ->leftJoin('image_shop', 'is', 'is.id_image = i.id_image');

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
    public function getImages($offset, $limit)
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
    public function getRemainingImagesCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(i.id_image) - ' . (int) $offset . ') as count');

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
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('i.id_image IN(' . implode(',', array_map('intval', $imageIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $productId
     * @param int $shopId
     *
     * @return false|string|null
     */
    public function getProductCoverImage($productId, $shopId)
    {
        $dbQuery = new \DbQuery();

        $dbQuery->select('imgs.id_image')
            ->from('image_shop', 'imgs')
            ->where('imgs.cover = 1')
            ->where('imgs.id_shop = ' . (int) $shopId)
            ->where('imgs.id_product = ' . (int) $productId);

        return $this->db->getValue($dbQuery);
    }

    /**
     * @param int $productId
     * @param int $attributeId
     * @param int $shopId
     * @param bool $includeCover
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductImages($productId, $attributeId, $shopId, $includeCover = false)
    {
        $dbQuery = new \DbQuery();

        $dbQuery->select('imgs.id_image')
            ->from('image_shop', 'imgs')
            ->leftJoin('image', 'img', 'imgs.id_image = img.id_image')
            ->where('imgs.id_shop = ' . (int) $shopId)
            ->where('imgs.id_product = ' . (int) $productId)
            ->orderBy('img.position ASC');

        if ((int) $attributeId !== 0) {
            $dbQuery->innerJoin(
                'product_attribute_image',
                'pai',
                'imgs.id_image = pai.id_image AND pai.id_product_attribute = ' . (int) $attributeId
            );
        }

        if (!$includeCover) {
            $dbQuery->where('(imgs.cover IS NULL OR imgs.cover = 0)');
        }

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
        $dbQuery->select('i.id_image');
        $dbQuery->select('i.id_product');
        $dbQuery->select('i.position');
        $dbQuery->select('i.cover');
        $dbQuery->select('il.id_lang');
        $dbQuery->select('il.legend');
        $dbQuery->select('is.id_shop');
    }
}
