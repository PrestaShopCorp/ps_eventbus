<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class CartProductRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'cart_product';

    /**
     * @param string $tableName
     * @param string alias
     * 
     * @return void
     */
    public function generateMinimalQuery($tableName, $alias)
    {
        $this->query = new \DbQuery();

        $this->query->from($tableName, $alias);
    }

    /**
     * @param string $langIso
     * @param bool $withSelecParameters
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso, $withSelecParameters)
    {
        $this->generateMinimalQuery(self::TABLE_NAME, 'cp');

        $this->query->where('cp.id_shop = ' . (int) parent::getShopContext()->id);
        
        if ($withSelecParameters) {
            $this->query
                ->select('cp.id_cart')
                ->select('cp.id_product')
                ->select('cp.id_product_attribute')
                ->select('cp.quantity')
                ->select('cp.date_add as created_at')
            ;
        }
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery($debug);
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where('cp.id_cart IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param $langIso
     * 
     * @return int
     * 
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, false);

        $this->query->select('(COUNT(*) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return $result[0]['count'];
    }
}
