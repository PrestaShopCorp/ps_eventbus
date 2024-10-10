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

class TaxeRepository extends AbstractRepository
{
    const TABLE_NAME = 'tax';

    /**
     * @var array<mixed>
     */
    private $countryIsoCodeCache = [];

    /**
     * @param int $zoneId
     * @param int $taxRulesGroupId
     * @param bool $active
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCarrierTaxesByZone($zoneId, $taxRulesGroupId, $active)
    {
        $cacheKey = $zoneId . '-' . (int) $active;

        if (!isset($this->countryIsoCodeCache[$cacheKey])) {
            $this->generateMinimalQuery(self::TABLE_NAME, 't');

            $this->query
                ->innerJoin('tax_rule', 'tr', 'tr.id_tax = t.id_tax')
                ->innerJoin('tax_rules_group', 'trg', 'trg.id_tax_rules_group = tr.id_tax_rules_group')
                ->innerJoin('tax_rules_group_shop', 'trgs', 'trgs.id_tax_rules_group = tr.id_tax_rules_group')
                ->innerJoin('tax_lang', 'tl', 'tl.id_tax = t.id_tax')
                ->leftJoin('country', 'c', 'c.id_country = tr.id_country')
                ->leftJoin('state', 's', 's.id_state = tr.id_state')
                ->where('tr.id_tax_rules_group = ' . (int) $taxRulesGroupId)
                ->where('c.active = ' . (bool) $active)
                ->where('s.active = ' . (bool) $active . ' OR s.active IS NULL')
                ->where('t.active = ' . (bool) $active)
                ->where('c.id_zone = ' . (int) $zoneId . ' OR s.id_zone = ' . (int) $zoneId)
                ->where('c.iso_code IS NOT NULL')
                ->where('trgs.id_shop = ' . parent::getShopContext()->id)
                ->where('tl.id_lang = ' . (int) parent::getLanguageContext()->id)
            ;

            $this->query
                ->select('t.rate')
                ->select('c.iso_code as country_iso_code')
                ->select('GROUP_CONCAT(s.iso_code SEPARATOR ",") as state_iso_code')
            ;

            $this->countryIsoCodeCache[$cacheKey] = $this->runQuery(false);
        }

        return $this->countryIsoCodeCache[$cacheKey];
    }
}
