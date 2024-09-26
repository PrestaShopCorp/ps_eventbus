<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class WishlistRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'wishlist';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'w');

        $this->query->where('w.id_shop = ' . parent::getShopContext()->id);

        if ($withSelecParameters) {
            $this->query
                ->select('w.id_wishlist')
                ->select('w.id_customer')
                ->select('w.id_shop')
                ->select('w.id_shop_group')
                ->select('w.token')
                ->select('w.name')
                ->select('w.counter')
                ->select('w.date_add AS created_at')
                ->select('w.date_upd as updated_at')
                ->select('w.default')
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
        // need this module for this table : https://addons.prestashop.com/en/undownloadable/9131-wishlist-block.html
        if (empty($this->checkIfPsWishlistIsInstalled())) {
            return [];
        }

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
            ->where('ps.id_wishlist IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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
        // need this module for this table : https://addons.prestashop.com/en/undownloadable/9131-wishlist-block.html
        if (empty($this->checkIfPsWishlistIsInstalled())) {
            return 0;
        }

        $this->generateFullQuery($langIso, false);

        $this->query->select('(COUNT(*) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return $result[0]['count'];
    }

    /**
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    private function checkIfPsWishlistIsInstalled()
    {
        $moduleisInstalledQuery = 'SELECT * FROM information_schema.tables WHERE table_name LIKE \'%wishlist\' LIMIT 1;';

        return $this->db->executeS($moduleisInstalledQuery, false);
    }
}
