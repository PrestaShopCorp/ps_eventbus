<?php

use PrestaShop\Module\PsEventbus\Config\Config;

/**
 * @return bool
 */
function upgrade_module_1_7_2()
{
    $db = Db::getInstance();

    $db->update('eventbus_incremental_sync', ['type' => Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS], '`type` = "custom_product_carrier"');
    $db->update('eventbus_incremental_sync', ['type' => Config::COLLECTION_SPECIFIC_PRICES], '`type` = "specific_price"');
    $db->update('eventbus_incremental_sync', ['type' => Config::COLLECTION_CARRIERS], '`type` = "carrier"');

    return true;
}
