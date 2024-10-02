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

namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class EmployeeRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'employee';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'e');

        $this->query
            ->leftJoin('employee_shop', 'es', 'es.id_employee = e.id_employee')
            ->where('es.id_shop = ' . parent::getShopContext()->id)
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('e.id_employee')
                ->select('e.id_profile')
                ->select('e.id_lang')
                ->select('e.email')
                ->select('e.bo_color')
                ->select('e.bo_theme')
                ->select('e.bo_css')
                ->select('e.default_tab')
                ->select('e.bo_width')
                ->select('e.bo_menu')
                ->select('e.active')
                ->select('e.optin')
                ->select('e.id_last_order')
                ->select('e.id_last_customer_message')
                ->select('e.id_last_customer')
                ->select('e.last_connection_date')
                ->select('es.id_shop as id_shop')
            ;

            // https://github.com/PrestaShop/PrestaShop/commit/20f1d9fe8a03559dfa9d1f7109de1f70c99f1874#diff-cde6a9d4a58afb13ff068801ee09c0e712c5e90b0cbf5632a0cc965f15cb6802R107
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.8.0', '>=')) {
                $this->query->select('e.has_enabled_gravatar');
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
            ->where('e.id_employee IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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
}
