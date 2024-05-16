<?php

/**
 * @return bool
 */
function upgrade_module_3_0_12()
{
    $db = Db::getInstance();

    $query = 'SELECT version FROM `' . _DB_PREFIX_ . 'module` WHERE name = \'ps_eventbus\'';

    $result = $db->executeS($query);

    // If previous installed version number is between 3.0.8 and 3.0.11, truncate _eventbus_incremental_sync and _eventbus_type_sync tables
    if (in_array($result[0]['version'], ['3.0.8', '3.0.9', '3.0.10', '3.0.11'])) {
        $truncateIncrementalSyncTable = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'eventbus_incremental_sync`;';
        $truncateTypeSyncTable = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'eventbus_type_sync`;';

        $db->execute($truncateIncrementalSyncTable);
        $db->execute($truncateTypeSyncTable);
    }

    return true;
}
