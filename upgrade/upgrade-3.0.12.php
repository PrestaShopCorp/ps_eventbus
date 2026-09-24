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
 * @return bool
 */
function upgrade_module_3_0_12()
{
    $db = Db::getInstance();

    $query = 'SELECT version FROM `' . _DB_PREFIX_ . 'module` WHERE name = \'ps_eventbus\'';

    $result = $db->executeS($query);

    // If previous installed version number is between 3.0.8 and 3.0.11, truncate _eventbus_incremental_sync and _eventbus_type_sync tables
    if (in_array($result[0]['version'], ['3.0.8', '3.0.9', '3.0.10', '3.0.11'])) {
        $truncateIncrementalSyncTable = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'eventbus_incremental_sync`;';
        $truncateTypeSyncTable = 'TRUNCATE TABLE `' . _DB_PREFIX_ . 'eventbus_type_sync`;';

        $db->execute($truncateIncrementalSyncTable);
        $db->execute($truncateTypeSyncTable);
    }

    return true;
}
