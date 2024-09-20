<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class CurrencyRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'currency';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'c');

        if ($this->isCurrencyLangAvailable()) {
            $this->query->innerJoin('currency_lang', 'cl', 'cl.id_currency = c.id_currency');
        }

        if ($withSelecParameters) {
            $this->query
                ->select('c.id_currency')
                ->select('c.iso_code')
                ->select('c.conversion_rate')
                ->select('c.deleted')
                ->select('c.active')
            ;

            if ($this->isCurrencyLangAvailable()) {
                $this->query->select('cl.name');
            } else {
                $this->query->select('\'\' as name');
            }

            // https://github.com/PrestaShop/PrestaShop/commit/37807f66b40b0cebb365ef952e919be15e9d6b2f#diff-3f41d3529ffdbfd1b994927eb91826a32a0560697025a734cf128a2c8e092a45R124
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
                $this->query->select('c.precision');
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
            ->where('c.id_currency IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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

    /**
     * @return mixed
     */
    private function isCurrencyLangAvailable()
    {
        return defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.6', '>=');
    }
}
