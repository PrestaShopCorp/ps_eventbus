<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class StockMvtRepository
{
    /**
     * @var \Db
     */
    private $db;

    public function __construct()
    {
        $this->db = \Db::getInstance();
    }

    /**
     * @param string $langIso
     *
     * @return \DbQuery
     */
    public function getBaseQuery($langIso)
    {
        /** @var int $langId */
        $langId = (int) \Language::getIdByIso($langIso);
        $query = new \DbQuery();
        $query->from('stock_mvt', 'sm')
            ->innerJoin('stock_mvt_reason', 'smr', 'sm.id_stock_mvt_reason = smr.id_stock_mvt_reason')
            ->innerJoin('stock_mvt_reason_lang', 'smrl', 'sm.id_stock_mvt_reason = smrl.id_stock_mvt_reason AND smrl.id_lang = ' . (int) $langId);

        return $query;
    }

    /**
     * @param string $langIso
     * @param array $stockIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStockMvts($langIso, $stockIds)
    {
        $query = $this->getBaseQuery($langIso);

        $this->addSelectParameters($query);

        $query->where('sm.id_stock IN(' . implode(',', array_map('intval', $stockIds)) . ')');

        return $this->db->executeS($query);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('sm.id_stock_mvt, sm.id_stock, sm.id_order, sm.id_supply_order, sm.id_stock_mvt_reason, smrl.name, smrl.id_lang');
        $query->select('sm.id_employee, sm.employee_lastname, sm.employee_firstname, sm.physical_quantity, sm.date_add, sm.sign, sm.price_te');
        $query->select('sm.last_wa, sm.current_wa, sm.referer, smr.deleted');
    }
}
