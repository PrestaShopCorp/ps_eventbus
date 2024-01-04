<?php

/**
 * @return bool
 */
function upgrade_module_2_3_5($module)
{
    $db = Db::getInstance();

    $query = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'eventbus_live_sync` (
        `shop_content`   VARCHAR(50) NOT NULL,
        `last_change_at` DATETIME    NOT NULL,
        PRIMARY KEY (`shop_content`)
    ) ENGINE = ENGINE_TYPE
      DEFAULT CHARSET = utf8;';

    $db->execute($query);

    return true;
}
