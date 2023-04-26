<?php

/**
 * @return bool
 */
function upgrade_module_1_10_8($module)
{
    $module->registerhook('actionObjectStockAddAfter');
    $module->registerhook('actionObjectStockUpdateAfter');

    return true;
}
