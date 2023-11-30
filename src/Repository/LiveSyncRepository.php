<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class LiveSyncRepository
{
    /**
     * @var \Db
     */
    private $db;

    /**
     * @param \Db $db
     */
    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $shopContent
     *
     * @return string|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getLastChangeAtByShopContent(string $shopContent)
    {
        $query = '
            SELECT `last_change_at`
            FROM `' . _DB_PREFIX_ . 'eventbus_live_sync` `eb_ls`
            WHERE `eb_ls`.`shop_content` = "' . pSQL($shopContent) . '"
            LIMIT 1
        ';

        $result = $this->db->executeS($query);

        if (is_array($result)) {
            return $result[0]['last_change_at'];
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
    public function upsertDebounce(string $shopContent, string $lastChangeAt)
    {
        $query = '
            INSERT INTO `' . _DB_PREFIX_ . 'eventbus_live_sync` (`shop_content`, `last_change_at`)
            VALUES ("' . pSQL($shopContent) . '", "' . pSQL($lastChangeAt) . '")
            ON DUPLICATE KEY UPDATE `last_change_at` = "' . pSQL($lastChangeAt) . '"
        ';

        return $this->db->execute($query);
    }
}
