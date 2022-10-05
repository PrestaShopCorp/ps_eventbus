<?php

/**
 * @return bool
 */
function upgrade_module_1_8_1()
{
    $db = Db::getInstance();

    $db->update('eventbus_type_sync', ['full_sync_finished' => 0], '`type` = "orders"');
    $db->update('eventbus_type_sync', ['full_sync_finished' => 0], '`type` = "info"');

    return true;
}
