<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Repository\RepositoryInterface;
use PrestaShop\Module\PsEventbus\Repository\AbstractRepository;

class OrderCartRuleRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'order_cart_rule';

    /**
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateBaseQuery()
    {
        $this->query = new \DbQuery();

        $this->query->from(self::TABLE_NAME, 'ocr');

        $this->query->select('ocr.id_order_cart_rule');
        $this->query->select('ocr.id_order');
        $this->query->select('ocr.id_cart_rule');
        $this->query->select('ocr.id_order_invoice');
        $this->query->select('ocr.name');
        $this->query->select('ocr.value');
        $this->query->select('ocr.value_tax_excl');
        $this->query->select('ocr.free_shipping');

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
        $this->generateBaseQuery();

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
        $this->generateBaseQuery();

        $this->query->where('ocr.id_order IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit);

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     * @param string $langIso
     * @param bool $debug
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $langIso, $debug)
    {
        $result = $this->getContentsForFull($offset, 1, $langIso, $debug);

        if (!is_array($result) || empty($result)) {
            return 0;
        }

        return count($result);
    }
}
