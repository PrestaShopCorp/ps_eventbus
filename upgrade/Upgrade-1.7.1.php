<?php

/**
 * @return bool
 */
function upgrade_module_1_7_1()
{
    $db = Db::getInstance();

    $db->update('eventbus_type_sync', ['full_sync_finished' => 0], '`type` = "products"');

    return true;
}
