<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

class OrderHistoryRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'order_history';

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
        $langId = (int) \Language::getIdByIso($langIso);

        $this->generateMinimalQuery(self::TABLE_NAME, 'oh');

        $this->query
            ->innerJoin('order_state', 'os', 'os.id_order_state = oh.id_order_State')
            ->innerJoin('order_state_lang', 'osl', 'osl.id_order_state = os.id_order_State AND osl.id_lang = ' . (int) $langId)
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('oh.id_order_state')
                ->select('osl.name')
                ->select('osl.template')
                ->select('oh.date_add')
                ->select('oh.id_order')
                ->select('oh.id_order_history')
                ->select('os.logable AS is_validated')
                ->select('os.delivery AS is_delivered')
                ->select('os.shipped AS is_shipped')
                ->select('os.paid AS is_paid')
                ->select('os.deleted AS is_deleted')
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
            ->where('oh.id_order_state IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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
     * @param array<mixed> $orderIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderHistoryIdsByOrderIds($orderIds, $langIso, $debug)
    {
        if (!$orderIds) {
            return [];
        }

        $this->generateFullQuery($langIso, true);

        $this->query->where('oh.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')');

        return $this->runQuery($debug);
    }
}
