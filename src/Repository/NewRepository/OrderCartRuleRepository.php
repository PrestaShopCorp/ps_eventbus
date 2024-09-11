<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class OrderCartRuleRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'order_cart_rule';

    /**
     * @return void
     */
    public function generateMinimalQuery()
    {
        $this->query = new \DbQuery();

        $this->query->from(self::TABLE_NAME, 'ocr');
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
        $this->generateMinimalQuery();

        $this->query
            ->select('ocr.id_order_cart_rule')
            ->select('ocr.id_order')
            ->select('ocr.id_cart_rule')
            ->select('ocr.id_order_invoice')
            ->select('ocr.name')
            ->select('ocr.value')
            ->select('ocr.value_tax_excl')
            ->select('ocr.free_shipping');

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
            $this->query->select('ocr.deleted');
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
            ->where('ocr.id_order_cart_rule IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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

        $this->query->select('(COUNT(ocr.id_order_cart_rule) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return $result[0]['count'];
    }
}
