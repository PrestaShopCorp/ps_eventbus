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

class InfoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getMultiShopCount()
    {
        $this->generateMinimalQuery('shop', 's');

        $this->query->where('s.active = 1 and s.deleted = 0');
        $this->query->select('COUNT(s.id_shop)');

        return (int) $this->db->getValue($this->query);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        $this->generateMinimalQuery('configuration', 'c');

        $this->query->where('c.name = "PS_INSTALL_VERSION"');
        $this->query->select('c.date_add as created_at');

        return (string) $this->db->getValue($this->query);
    }

    /**
     * Gives back the first iso_code registered, which correspond to the default country of this shop
     *
     * @return string
     */
    public function getShopCountryCode()
    {
        $this->generateMinimalQuery('country', 'c');

        $this->query->where('c.id_country = ' . \Configuration::get('PS_COUNTRY_DEFAULT'));
        $this->query->select('c.iso_code');

        return (string) $this->db->getValue($this->query);
    }
}
