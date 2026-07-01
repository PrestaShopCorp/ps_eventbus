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
 * Switches eventbus_type_sync from offset to seek pagination:
 *  - adds `last_seek_key` (the new cursor, starts NULL for every row)
 *  - drops the now-unused `offset` column
 *
 * @return bool
 */
function upgrade_module_4_1_0()
{
    $db = Db::getInstance();

    $hasLastSeekKey = $db->executeS(
        'SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'eventbus_type_sync` LIKE "last_seek_key"'
    );

    if (empty($hasLastSeekKey)) {
        $db->execute(
            'ALTER TABLE `' . _DB_PREFIX_ . 'eventbus_type_sync`
             ADD COLUMN `last_seek_key` VARCHAR(190) DEFAULT NULL'
        );
    }

    $hasOffset = $db->executeS(
        'SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'eventbus_type_sync` LIKE "offset"'
    );

    if (!empty($hasOffset)) {
        $db->execute(
            'ALTER TABLE `' . _DB_PREFIX_ . 'eventbus_type_sync`
             DROP COLUMN `offset`'
        );
    }

    return true;
}
