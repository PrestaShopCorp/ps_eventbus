<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderStatusHistoryRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'order_history';

    /**
     * @param string $langIso
     * @param bool $withSelecParameters
     *
     * @return void
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
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery();
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where("oh.id_order_history IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            ->limit($limit)
        ;

        return $this->runQuery();
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

        $result = $this->runQuery(true);

        return !empty($result[0]['count']) ? $result[0]['count'] : 0;
    }

    /**
     * @param array<mixed> $orderIds
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderStatusHistoriesByOrderIds($orderIds, $langIso)
    {
        if (!$orderIds) {
            return [];
        }

        $this->generateFullQuery($langIso, true);

        $this->query->where("oh.id_order IN ('" . implode("','", array_map('intval', $orderIds)) . "')");

        return $this->runQuery();
    }
}
