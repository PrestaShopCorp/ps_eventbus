<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class LiveSyncRepository
{
    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Db $db, \Context $context)
    {
        $this->db = $db;
    }

    /**
     * @param string $shopContent
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getLastChangeAtByShopContent(string $shopContent)
    {
        $query = '
            SELECT `last_change_at`
            FROM `' . _DB_PREFIX_ . 'eventbus_live_sync_debounce` `eb_debounce`
            WHERE `eb_debounce`.`shop_content` = "' . pSQL($shopContent) . '"
            LIMIT 1
        ';

        $result = $this->db->executeS($query);

        return $result ? $result[0]['last_change_at'] : null;
    }

    /**
     * @param string $shopContent
     * @param Date $lastChangeAt
     *
     * @return bool|\mysqli_result|\PDOStatement|resource
     *
     * @throws \PrestaShopDatabaseException
     */
    public function upsertDebounce(string $shopContent, string $lastChangeAt)
    {
        $query = '
            INSERT INTO `' . _DB_PREFIX_ . 'eventbus_live_sync_debounce` (`shop_content`, `last_change_at`)
            VALUES ("' . pSQL($shopContent) . '", "' . pSQL($lastChangeAt) . '")
            ON DUPLICATE KEY UPDATE `last_change_at` = "' . pSQL($lastChangeAt) . '"
        ';

        return $this->db->execute($query);
    }
}
