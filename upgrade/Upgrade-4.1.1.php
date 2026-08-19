<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Repairs the `DATETIME` columns that could have been filled with an ISO 8601
 * value before the module started normalizing dates.
 *
 * On a permissive `sql_mode` MySQL truncated `2026-08-13T11:26:59+02:00` to a
 * valid datetime and only raised a warning, but depending on the server the
 * same insert could also land as a zero date, which then breaks every read
 * that hydrates a \DateTime from it.
 *
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
function upgrade_module_4_1_1()
{
    $db = Db::getInstance();

    $tables = [
        'eventbus_job' => 'created_at',
        'eventbus_incremental_sync' => 'created_at',
        'eventbus_type_sync' => 'last_sync_date',
        'eventbus_live_sync' => 'last_change_at',
    ];

    foreach ($tables as $table => $column) {
        // a zero date cannot be compared with a literal in strict mode, hence YEAR()
        $db->execute(
            'UPDATE `' . _DB_PREFIX_ . $table . '`
              SET `' . $column . '` = NOW()
              WHERE `' . $column . '` IS NULL
                 OR YEAR(`' . $column . '`) < 1000'
        );
    }

    $db->execute(
        'UPDATE `' . _DB_PREFIX_ . 'eventbus_type_sync`
            SET `last_seek_key` = NULL
          WHERE `type` = "cart_products"
            AND `full_sync_finished` = 0'
    );

    return true;
}
