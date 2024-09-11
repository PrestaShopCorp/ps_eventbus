<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class CarrierRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'carrier';

    /**
     * @return void
     */
    public function generateMinimalQuery()
    {
        $this->query = new \DbQuery();

        $this->query->from(self::TABLE_NAME, 'c');
    }

    /**
     * @param string $langIso
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso)
    {
        $langId = (int) \Language::getIdByIso($langIso);

        $this->generateMinimalQuery();

        $this->query
            ->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . $langId)
            ->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier')
        ;

        $this->query
            ->where('cs.id_shop = ' . (int) parent::getShopId())
            ->where('deleted=0')
        ;

        $this->query->select('c.*')
            ->select('cl.delay AS delay');
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
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $this->generateFullQuery($langIso);

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
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $this->generateFullQuery($langIso);

        $this->query
            ->where('c.id_carrier IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit);

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset)
    {
        $this->generateMinimalQuery();

        $this->query->select('(COUNT(c.id_carrier) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return $result[0]['count'];
    }
}
