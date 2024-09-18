<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class ProductSupplierRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'product_supplier';

    /**
     * @param string $tableName
     * @param string $alias
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
        $this->generateMinimalQuery(self::TABLE_NAME, 'ps');

        if ($withSelecParameters) {
            $this->query
                ->select('ps.id_product_supplier')
                ->select('ps.id_product')
                ->select('ps.id_product_attribute')
                ->select('ps.id_supplier')
                ->select('ps.product_supplier_reference')
                ->select('ps.product_supplier_price_te')
                ->select('ps.id_currency')
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
            ->where('ps.id_product_supplier IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
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
