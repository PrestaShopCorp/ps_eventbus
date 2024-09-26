<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */



namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class StockRepository
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
        $query->from('stock_available', 'sa')
            ->where('sa.id_shop = ' . (int) $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStocks($offset, $limit)
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
    public function getRemainingStocksCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(sa.id_stock_available) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array<mixed> $productIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStocksIncremental($limit, $productIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('sa.id_product IN(' . implode(',', array_map('intval', $productIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
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
     * @param array<mixed> $productIds
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStocksIdsByProductIds($productIds)
    {
        if (!$productIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('sa.id_stock_available as id');
        $query->where('sa.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('sa.id_stock_available, sa.id_product, sa.id_product_attribute, sa.id_shop, sa.id_shop_group');
        $query->select('sa.quantity, sa.depends_on_stock, sa.out_of_stock');

        // https://github.com/PrestaShop/PrestaShop/commit/2a3269ad93b1985f2615d6604458061d4989f0ea#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2186
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.2.0', '>=')) {
            $query->select('sa.physical_quantity, sa.reserved_quantity');
        }
        // https://github.com/PrestaShop/PrestaShop/commit/4c7d58a905dfb61c7fb2ef4a1f9b4fab2a8d8ecb#diff-e57fb1deeaab9e9079505333394d58f0bf7bb40280b4382aad1278c08c73e2e8R58
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.5.0', '>=')) {
            $query->select('sa.location');
        }
    }
}
