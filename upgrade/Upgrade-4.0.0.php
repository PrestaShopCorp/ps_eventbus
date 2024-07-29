<?php

use PrestaShop\Module\PsEventbus\Config\Config;

/**
 * @return bool
 */
function upgrade_module_4_0_0()
{
    $db = Db::getInstance();
    
    // Update eventbus_incremental_sync and add 'action' column
    $editIncrementalTable = 'ALTER TABLE `' . _DB_PREFIX_ . 'eventbus_incremental_sync` ADD action varchar(50) NOT NULL;';
    $editIncrementalTableResult = $db->query($editIncrementalTable);
 
    // If ALTER is failed, stop update process
    if (!$editIncrementalTableResult) {
        return false;
    }

    // Backup data from eventbus_deleted_objects
    $backupDeletedTable = 'SELECT * FROM `' . _DB_PREFIX_ . 'eventbus_deleted_objects`';
    $backupDeletedTableResult = $db->executeS($backupDeletedTable);

    $elementsCount = count($backupDeletedTableResult);
    $index = 0;

    // Insert data from backup into incremental table
    $updateIncrementalTable = 'INSERT INTO `' . _DB_PREFIX_ . 'eventbus_incremental_sync` (type, id_object, id_shop, lang_iso, created_at, action) VALUES ';

    foreach ($backupDeletedTableResult as $deletedContent) {
        $updateIncrementalTable .= "(
            '{$db->escape($deletedContent['type'])}',
            {$db->escape($deletedContent['id_object'])},
            {$db->escape($deletedContent['id_shop'])},
            {$db->escape($deletedContent['created_at'])}',
            deleted'
        )";

        if (++$index < $elementsCount) {
            $updateIncrementalTable .= ',';
        }
    }

    $updateIncrementalTable .= ' 
        ON DUPLICATE KEY UPDATE 
        type = VALUES(type),
        id_object = VALUES(id_object),
        id_shop = VALUES(id_shop),
        created_at = VALUES(created_at)
        action = deleted
    ';

    $updateIncrementalTableResult = (bool) $db->query($updateIncrementalTable);

    // If insert backup is failed, stop update process
    if (!$updateIncrementalTableResult) {
        return false;
    }

    // Drop eventbus_deleted_objects table
    $dropDeletedTable = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'eventbus_deleted_objects`';
    $dropDeletedTableResult = (bool) $db->query($dropDeletedTable);

    return $dropDeletedTableResult;
}
