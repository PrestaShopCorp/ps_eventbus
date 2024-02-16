<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CartProductRepository
{
    /**
     * @var PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;
    /**
     * @var PrestaShop\PrestaShop\Adapter\Entity\Context
     */
    private $context;

    public function __construct(\Db $db, PrestaShop\PrestaShop\Adapter\Entity\Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @return PrestaShop\PrestaShop\Adapter\Entity\DbQuery
     */
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

        $query->from('cart_product', 'cp')
            ->where('cp.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param array $cartIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
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
