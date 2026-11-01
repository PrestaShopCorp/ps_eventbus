<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Indexes the outbox by (type, id_shop, lang_iso).
 *
 * The outbox is capped, read and purged per (type, shop, language), but its
 * primary key (type, id_object, id_shop, lang_iso) only narrows a lookup to the
 * type: counting or deleting the rows of one shop and language scanned and
 * locked every row of the type, across all shops and languages.
 *
 * @return bool
 */
function upgrade_module_4_1_2()
{
    $db = Db::getInstance();

    $existingIndex = $db->executeS(
        'SHOW INDEXES FROM `' . _DB_PREFIX_ . 'eventbus_incremental_sync` WHERE Key_name = "type_shop_lang"'
    );

    if (!empty($existingIndex)) {
        return true;
    }

    return (bool) $db->execute(
        'ALTER TABLE `' . _DB_PREFIX_ . 'eventbus_incremental_sync`
            ADD INDEX `type_shop_lang` (`type`, `id_shop`, `lang_iso`)'
    );
}
