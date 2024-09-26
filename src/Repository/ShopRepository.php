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

class ShopRepository
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
     * @return int
     */
    public function getMultiShopCount()
    {
        $query = new \DbQuery();

        $query->select('COUNT(id_shop)')
            ->from('shop')
            ->where('active = 1 and deleted = 0');

        return (int) $this->db->getValue($query);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        $query = new \DbQuery();

        $query->select('date_add as created_at')
          ->from('configuration')
          ->where('name = "PS_INSTALL_VERSION"');

        return (string) $this->db->getValue($query);
    }

    /**
     * Gives back the first iso_code registered, which correspond to the default country of this shop
     *
     * @return string
     */
    public function getShopCountryCode()
    {
        $query = new \DbQuery();

        $query->select('iso_code')
          ->from('country')
          ->where('active = 1');

        return (string) $this->db->getValue($query);
    }
}
