<?php

/**
 * @return bool
 */
function upgrade_module_1_5_1()
{
    $db = Db::getInstance();

    $db->delete('eventbus_deleted_objects', 'id_object = 0');
    $db->delete('eventbus_incremental_sync', 'id_object = 0');

    return true;
}
