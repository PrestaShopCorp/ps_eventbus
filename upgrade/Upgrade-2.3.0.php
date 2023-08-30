<?php

/**
 * @return bool
 */
function upgrade_module_2_3_0($module)
{
    $module->registerhook('actionObjectManufacturerAddAfter');
    $module->registerhook('actionObjectManufacturerDeleteAfter');
    $module->registerhook('actionObjectManufacturerUpdateAfter');

    $module->registerhook('actionObjectSupplierAddAfter');
    $module->registerhook('actionObjectSupplierDeleteAfter');
    $module->registerhook('actionObjectSupplierUpdateAfter');

    return true;
}
