<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

/**
 * @property \DbQuery $query
 */
interface RepositoryInterface
{
    /**
     * @param string $tableName
     * @param string $alias
     *
     * @return void
     */
    public function generateMinimalQuery($tableName, $alias);

    /**
     * @param string $langIso
     * @param bool $withSelecParameters
     *
     * @return mixed
     */
    public function generateFullQuery($langIso, $withSelecParameters);

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function retrieveContentsForFull($offset, $limit, $langIso, $debug);

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

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
    public function countFullSyncContentLeft($offset, $limit, $langIso);
}
