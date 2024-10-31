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

class StateRepository extends AbstractRepository
{
    const TABLE_NAME = 'state';

    /**
     * @param int $zoneId
     * @param bool $active
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStateIsoCodesByZoneId($zoneId, $active)
    {
        $isoCodes = [];

        $this->generateMinimalQuery(self::TABLE_NAME, 's');

        $this->query->innerJoin('country', 'c', 'c.id_country = s.id_country')
            ->where('s.id_zone = ' . (int) $zoneId)
            ->where('s.active = ' . (bool) $active)
            ->where('c.active = ' . (bool) $active)
        ;

        $this->query->select('s.iso_code');

        $result = $this->runQuery(true);

        foreach ($result as $state) {
            $isoCodes[] = $state['iso_code'];
        }

        return $isoCodes;
    }
}
