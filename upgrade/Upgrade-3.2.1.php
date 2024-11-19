<?php

/**
 * @return bool
 */
function upgrade_module_3_2_1()
{
    $db = Db::getInstance();

    // Delete all entries with type "cart_rules" from eventbus_incremental_sync
    $db->delete('eventbus_incremental_sync', '`type` = "cart_rules"');

    // reset full sync for cart_rules
    $db->update(
        'eventbus_type_sync',
        [
            'offset' => 0,
            'full_sync_finished' => 0,
        ],
        '`type` = "cart_rules"'
    );

    return true;
}
