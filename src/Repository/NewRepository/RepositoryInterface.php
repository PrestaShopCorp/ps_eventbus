<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

/**
 * @property \DbQuery $query
 */
interface RepositoryInterface
{
    /**
     * @param string $tableName
     * @param string alias
     * 
     * @return void
     */
    public function generateMinimalQuery($tableName, $alias)

    /**
     * @param string $langIso
     *
     * @return mixed
     */
    public function generateFullQuery($langIso);

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug);

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug);

    /**
     * @param int $offset
     *
     * @return int
     */
    public function countFullSyncContentLeft($offset);
}
