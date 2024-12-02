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
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @return bool
 */
function upgrade_module_4_0_0()
{
    return 
        addPrimaryKeyToTypeSyncTable() &&
        addActionToIncrementalSyncTable() &&
        migrateDeleteTableToIncremantalTable()
    ;
}


function addPrimaryKeyToTypeSyncTable()
{
    $db = Db::getInstance();

    // Add primary key to eventbus_type_sync
    $editTypeSyncTable = 'ALTER TABLE `' . _DB_PREFIX_ . 'eventbus_type_sync` ADD PRIMARY KEY (type, id_shop, lang_iso);';
    
    return $db->query($editTypeSyncTable);
}

function addActionToIncrementalSyncTable()
{
    $db = Db::getInstance();

    // Update eventbus_incremental_sync and add 'action' column
    $editIncrementalTable = 'ALTER TABLE `' . _DB_PREFIX_ . 'eventbus_incremental_sync` ADD action varchar(50) NOT NULL;';
    
    return $db->query($editIncrementalTable);
}

function migrateDeleteTableToIncremantalTable()
{
    $db = Db::getInstance();

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

    return $db->query($dropDeletedTable);
}
