<?php

/**
 * @return bool
 */
function upgrade_module_1_10_0($module)
{
    $module->registerhook('actionObjectCustomerAddAfter');
    $module->registerhook('actionObjectCustomerUpdateAfter');
    $module->registerhook('actionObjectCustomerDeleteAfter');

    return true;
}
