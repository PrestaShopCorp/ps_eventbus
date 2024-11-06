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

class CarrierTaxeRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'carrier';

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
        $this->generateMinimalQuery(SELF::TABLE_NAME, 'ca');

        $this->query
            ->leftJoin('ps_carrier_tax_rules_group_shop', 'ctrgs', 'ca.id_carrier = ctrgs.id_carrier')
            ->leftJoin('ps_tax_rule', 'tr', 'tr.id_tax_rules_group = ctrgs.id_tax_rules_group')
            ->leftJoin('ps_tax', 't', 't.id_tax = tr.id_tax')
            ->leftJoin('ps_tax_lang', 'tl', 'tl.id_tax = t.id_tax')
            ->leftJoin('ps_country', 'co', 'co.id_country = tr.id_country')
            ->leftJoin('ps_delivery', 'd', 'd.id_carrier = ca.id_carrier')
            ->leftJoin('ps_state', 's', 's.id_state = tr.id_state')
        ;

        $this->query
            ->where('co.iso_code IS NOT NULL')
            ->where('d.id_delivery IS NOT NULL')
            ->where('co.active = 1')
            ->where('tl.id_lang = ' . (int) parent::getLanguageContext()->id)
        ;

        $this->query->groupBy('co.iso_code');

        $this->query
            ->select('ca.id_reference')
            ->select('d.id_zone')
            ->select('co.iso_code AS country_id')
            ->select('GROUP_CONCAT(s.iso_code SEPARATOR ",") as state_iso_code')
            ->select('t.rate AS tax_rate')
        ;
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
        if ($contentIds == []) {
            return [];
        }

        $this->generateFullQuery($langIso, true);

        $this->query
            ->where('d.id_carrier IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit);

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

        return $result[0]['count'];
    }
}
