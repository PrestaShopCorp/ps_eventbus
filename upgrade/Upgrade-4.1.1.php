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

    return true;
}
