<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * cart_products full sync switched from offset to seek pagination, changing the
 * meaning of its `last_seek_key`: it used to hold a row offset ("500"), it now
 * holds a "{id_cart}-{id_product}-{id_product_attribute}" triple. A key written
 * by the old code would be decoded as id_cart=500 and skip every cart below it,
 * so clear the cursor of any in-flight cart_products full sync to restart it
 * from scratch. Over-recording is safe; under-recording would drop carts.
 *
 * Finished syncs (full_sync_finished = 1) are left alone: they no longer resume
 * from the cursor, so their stale key is harmless and re-syncing would be waste.
 *
 * @return bool
 */
function upgrade_module_4_1_2()
{
    $db = Db::getInstance();

    return $db->execute(
        'UPDATE `' . _DB_PREFIX_ . 'eventbus_type_sync`
            SET `last_seek_key` = NULL
          WHERE `type` = "cart_products"
            AND `full_sync_finished` = 0'
    );
}
