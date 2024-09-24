<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class ModuleRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'module';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'm');

        $this->query->leftJoin('module_shop', 'm_shop', 'm.id_module = m_shop.id_module');

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->query->leftJoin('module_history', 'h', 'm.id_module = h.id_module');
        }

        if ($withSelecParameters) {
            /*
            * The `active` field of the "ps_module" table has been deprecated,
            * this is why we use the "ps_module_shop" table to check if a module is active or not
            */

            $this->query
                ->select('m.id_module as module_id')
                ->select('name')
                ->select('version as module_version')
                ->select('IF(m_shop.enable_device, 1, 0) as active')
            ;

            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>=')) {
                $this->query
                    ->select('date_add as created_at')
                    ->select('date_upd as updated_at')
                ;
            }
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
            ->where('m.id_module IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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
