<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
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
