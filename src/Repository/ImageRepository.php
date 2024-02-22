<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Db;
use DbQuery;
use PrestaShopDatabaseException;

class ImageRepository
{
    /**
     * @var Db
     */
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    /**
     * @return DbQuery
     */
    private function getBaseQuery()
    {
        $query = new DbQuery();

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
     * @throws PrestaShopDatabaseException
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
     * @throws PrestaShopDatabaseException
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
     * @param int $productId
     * @param int $shopId
     *
     * @return false|string|null
     */
    public function getProductCoverImage($productId, $shopId)
    {
        $query = new DbQuery();

        $query->select('imgs.id_image')
            ->from('image_shop', 'imgs')
            ->where('imgs.cover = 1')
            ->where('imgs.id_shop = ' . (int) $shopId)
            ->where('imgs.id_product = ' . (int) $productId);

        return $this->db->getValue($query);
    }

    /**
     * @param int $productId
     * @param int $attributeId
     * @param int $shopId
     * @param bool $includeCover
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws PrestaShopDatabaseException
     */
    public function getProductImages($productId, $attributeId, $shopId, $includeCover = false)
    {
        $query = new DbQuery();

        $query->select('imgs.id_image')
            ->from('image_shop', 'imgs')
            ->leftJoin('image', 'img', 'imgs.id_image = img.id_image')
            ->where('imgs.id_shop = ' . (int) $shopId)
            ->where('imgs.id_product = ' . (int) $productId)
            ->orderBy('img.position ASC');

        if ((int) $attributeId !== 0) {
            $query->innerJoin(
                'product_attribute_image',
                'pai',
                'imgs.id_image = pai.id_image AND pai.id_product_attribute = ' . (int) $attributeId
            );
        }

        if (!$includeCover) {
            $query->where('(imgs.cover IS NULL OR imgs.cover = 0)');
        }

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws PrestaShopDatabaseException
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
     * @param DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(DbQuery $query)
    {
        $query->select('it.id_image');
        $query->select('it.id_product');
        $query->select('it.id_lang');
        $query->select('it.id_shop');
        $query->select('it.position');
        $query->select('it.cover');
        $query->select('it.legend');
    }
}
