<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     * @param array<mixed> $stockIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
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
