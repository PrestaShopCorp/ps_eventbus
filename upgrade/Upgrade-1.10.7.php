<?php

/**
 * @return bool
 */
function upgrade_module_1_10_7($module)
{
    $module->registerhook('actionObjectStoreAddAfter');
    $module->registerhook('actionObjectStoreUpdateAfter');
    $module->registerhook('actionObjectStoreDeleteAfter');

    return true;
}
