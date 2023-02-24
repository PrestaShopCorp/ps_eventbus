<?php

/**
 * @return bool
 */
function upgrade_module_1_9_7()
{
    $db = Db::getInstance();

    $db->update('eventbus_type_sync', ['full_sync_finished' => 0], '`type` = "categories"');

    return true;
}
