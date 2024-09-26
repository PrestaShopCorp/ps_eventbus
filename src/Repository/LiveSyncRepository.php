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

class LiveSyncRepository
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
     * @param string $shopContent
     *
     * @return array<mixed>|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getShopContentInfo($shopContent)
    {
        $query = '
            SELECT `eb_ls`.`shop_content`, `eb_ls`.`last_change_at`
            FROM `' . _DB_PREFIX_ . 'eventbus_live_sync` `eb_ls`
            WHERE `eb_ls`.`shop_content` = "' . pSQL($shopContent) . '";
        ';

        $result = $this->db->executeS($query);

        if (is_array($result) && count($result) > 0) {
            return $result[0];
        }

        return null;
    }

    /**
     * @param string $shopContent
     * @param string $lastChangeAt
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     */
    public function upsertDebounce($shopContent, $lastChangeAt)
    {
        $query = '
            INSERT INTO `' . _DB_PREFIX_ . 'eventbus_live_sync` (`shop_content`, `last_change_at`)
            VALUES ("' . pSQL($shopContent) . '", "' . pSQL($lastChangeAt) . '")
            ON DUPLICATE KEY UPDATE `last_change_at` = "' . pSQL($lastChangeAt) . '";
        ';

        return $this->db->execute($query);
    }
}
