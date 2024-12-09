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
    if (!removeDuplicateEntryFromTypeSyncTable()) {
        throw new Exception('Failed to remove duplicate entry from eventbus_type_sync.');
    }

    // Ajouter la clé primaire
    if (!addPrimaryKeyToTypeSyncTable()) {
        throw new Exception('Failed to add primary key to eventbus_type_sync.');
    }

    // Ajouter la colonne action
    if (!addActionToIncrementalSyncTable()) {
        throw new Exception("Failed to add 'action' column to eventbus_incremental_sync.");
    }

    // Migrer les données
    if (!migrateDeleteTableToIncremantalTable()) {
        throw new Exception('Failed to migrate data to eventbus_incremental_sync.');
    }

    return true;
}

function removeDuplicateEntryFromTypeSyncTable()
{
    if (tableTypeSyncAlreadyMigrated()) {
        return true;
    }

    $db = Db::getInstance();

    // Check if old table exist (after error at install ?)
    $checkOldTableQuery = "SHOW TABLES LIKE '" . _DB_PREFIX_ . "eventbus_type_sync_old';";
    $oldTableExists = $db->executeS($checkOldTableQuery);

    if ($oldTableExists) {
        // If temp table exist (after error at install ?), rename to "eventbus_type_sync"
        $renameOldTableQuery = "RENAME TABLE `" . _DB_PREFIX_ . "eventbus_type_sync_old` TO `" . _DB_PREFIX_ . "eventbus_type_sync`;";
        $db->query($renameOldTableQuery);
    }

    // Rename original table to old (for temporary edit)
    $renameTableQuery = "RENAME TABLE `" . _DB_PREFIX_ . "eventbus_type_sync` TO `" . _DB_PREFIX_ . "eventbus_type_sync_old`;";
    $db->query($renameTableQuery);
    
    // Create new table, clone of original table (old here)
    $createNewTableQuery = "CREATE TABLE `" . _DB_PREFIX_ . "eventbus_type_sync` LIKE `" . _DB_PREFIX_ . "eventbus_type_sync_old`;";
    $db->query($createNewTableQuery);

    // Migrate data from old table to new table, and remove duplicate entries
    $migrateToNewTableQuery = "
        INSERT INTO `" . _DB_PREFIX_ . "eventbus_type_sync` (`type`, `offset`, `id_shop`, `lang_iso`, `full_sync_finished`, `last_sync_date`)
        SELECT 
            `type`, 
            CASE 
                WHEN COUNT(*) > 1 THEN 0 -- Si plusieurs entrées similaires, offset = 0
                ELSE MAX(`offset`) -- Sinon, on garde la valeur existante
            END AS `offset`,
            `id_shop`, 
            `lang_iso`,
            CASE 
                WHEN COUNT(*) > 1 THEN 0 -- Si plusieurs entrées similaires, full_sync_finished = 0
                ELSE MAX(`full_sync_finished`) -- Sinon, on garde la valeur existante
            END AS `full_sync_finished`,
            CASE 
                WHEN COUNT(*) > 1 THEN MAX(`last_sync_date`) -- Si plusieurs entrées similaires, garder la dernière date
                ELSE MAX(`last_sync_date`) -- Sinon, on garde la date existante
            END AS `last_sync_date`
        FROM `" . _DB_PREFIX_ . "eventbus_type_sync_old`
        GROUP BY `type`, `id_shop`, `lang_iso`;
    ";
    $db->query($migrateToNewTableQuery);

    // remove old table
    $dropOldTableQuery = "DROP TABLE `" . _DB_PREFIX_ . "eventbus_type_sync_old`;";
    $db->query($dropOldTableQuery);

    return true; // Succès
}


function addPrimaryKeyToTypeSyncTable()
{
    if (tableTypeSyncAlreadyMigrated()) {
        return true;
    }

    $db = Db::getInstance();

    // Add primary key
    $editTypeSyncTable = "ALTER TABLE `" . _DB_PREFIX_ . "eventbus_type_sync` ADD PRIMARY KEY (type, id_shop, lang_iso);";

    return (bool) $db->query($editTypeSyncTable);
}

function addActionToIncrementalSyncTable()
{
    $db = Db::getInstance();

    // Check if the 'action' column exists in the table
    $checkColumnQuery = "SHOW COLUMNS FROM `" . _DB_PREFIX_ . "eventbus_incremental_sync` LIKE 'action';";
    $columns = $db->executeS($checkColumnQuery);

    // Add 'action' column if it does'nt exist
    if (empty($columns)) {
        $editIncrementalTable = "ALTER TABLE `" . _DB_PREFIX_ . "eventbus_incremental_sync` ADD action varchar(50) NOT NULL DEFAULT 'upsert';";

        return (bool) $db->query($editIncrementalTable);
    }

    return true; // Column already exists, no need to alter
}

function migrateDeleteTableToIncremantalTable()
{
    $db = Db::getInstance();

    // Get default lang_iso
    $defaultLangId = Configuration::get('PS_LANG_DEFAULT');
    $defaultLangIso = Language::getIsoById($defaultLangId);

    // Prepare the query with dynamic lang_iso
    $migrationRequest = sprintf(
        "INSERT INTO ps_eventbus_incremental_sync (type, id_object, id_shop, lang_iso, created_at, action)
        SELECT
            type,
            id_object,
            id_shop,
            '%s', -- This is a dynamic value
            created_at,
            'deleted'
        FROM ps_eventbus_deleted_objects
        ON DUPLICATE KEY UPDATE
            type = VALUES(type),
            id_object = VALUES(id_object),
            id_shop = VALUES(id_shop),
            lang_iso = VALUES(lang_iso),
            created_at = VALUES(created_at),
            action = VALUES(action);",
        $defaultLangIso // This is where the dynamic value is injected
    );

    $migrationSucceded = (bool) $db->query($migrationRequest);

    if ($migrationSucceded) {
        // Drop eventbus_deleted_objects table
        $dropDeletedTable = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "eventbus_deleted_objects`";

        return $db->query($dropDeletedTable);
    }
}

function tableTypeSyncAlreadyMigrated()
{
    $db = Db::getInstance();

    // Check if the primary key exists by inspecting the indexes
    $checkPrimaryKeyQuery = "SHOW INDEXES FROM `" . _DB_PREFIX_ . "eventbus_type_sync` WHERE Key_name = 'PRIMARY';";

    // Exécuter la requête pour obtenir les index et vérifier s'il y a un index primaire
    return $db->executeS($checkPrimaryKeyQuery);
}
