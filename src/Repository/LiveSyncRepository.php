<?php

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
