<?php

/**
 * @return bool
 */
function upgrade_module_1_7_11()
{
    $db = Db::getInstance();

    $db->update('eventbus_type_sync', ['full_sync_finished' => 0], '`type` = "orders"');

    return true;
}
