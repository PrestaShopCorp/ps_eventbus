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

class SupplierRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'supplier';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'su');

        $langId = (int) \Language::getIdByIso($langIso);

        $this->query
            ->innerJoin('supplier_lang', 'sul', 'su.id_supplier = sul.id_supplier AND sul.id_lang = ' . (int) $langId)
            ->innerJoin('supplier_shop', 'sus', 'su.id_supplier = sus.id_supplier AND sus.id_shop = ' . parent::getShopContext()->id)
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('su.id_supplier')
                ->select('su.name')
                ->select('su.date_add as created_at')
                ->select('su.date_upd as updated_at')
                ->select('su.active')
                ->select('sul.id_lang')
                ->select('sul.description')
                ->select('sul.meta_title')
                ->select('sul.meta_description')
                ->select('sus.id_shop')
            ;

            // REMOVED HERE: https://github.com/PrestaShop/PrestaShop/commit/f37a8f61017654bae160b528a1a2eaf49edbdac0
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '9.0', '<')) {
                $this->query->select('sul.meta_keywords');
            }
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
            ->where("su.id_supplier IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
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
}
