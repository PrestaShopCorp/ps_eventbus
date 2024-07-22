<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CartProductRepository
{
    /**
     * @var \Db
     */
    private $db;
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
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new \DbQuery();

        $query->from('cart_product', 'cp')
            ->where('cp.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param array $cartIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCartProducts(array $cartIds)
    {
        $query = $this->getBaseQuery();

        $query->select('cp.id_cart, cp.id_product, cp.id_product_attribute, cp.quantity, cp.date_add as created_at');

        if (!empty($cartIds)) {
            $query->where('cp.id_cart IN (' . implode(',', array_map('intval', $cartIds)) . ')');
        }

        return $this->db->executeS($query);
    }
}
