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

class StockRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'stock_available';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'sa');

        $this->query->where('sa.id_shop = ' . (int) parent::getShopContext()->id);

        if ($withSelecParameters) {
            $this->query
                ->select('sa.id_stock_available')
                ->select('sa.id_product')
                ->select('sa.id_product_attribute')
                ->select('sa.id_shop')
                ->select('sa.id_shop_group')
                ->select('sa.quantity')
                ->select('sa.depends_on_stock')
                ->select('sa.out_of_stock')
            ;

            // https://github.com/PrestaShop/PrestaShop/commit/2a3269ad93b1985f2615d6604458061d4989f0ea#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2186
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.2.0', '>=')) {
                $this->query
                    ->select('sa.physical_quantity')
                    ->select('sa.reserved_quantity')
                ;
            }

            // https://github.com/PrestaShop/PrestaShop/commit/4c7d58a905dfb61c7fb2ef4a1f9b4fab2a8d8ecb#diff-e57fb1deeaab9e9079505333394d58f0bf7bb40280b4382aad1278c08c73e2e8R58
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.5.0', '>=')) {
                $this->query->select('sa.location');
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
            ->where("sa.id_stock_available IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
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
