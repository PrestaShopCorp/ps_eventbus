<?php

/**
 * @return bool
 */
function upgrade_module_3_0_5($module)
{
    $module->registerhook('actionObjectEmployeeAddAfter');
    $module->registerhook('actionObjectEmployeeDeleteAfter');
    $module->registerhook('actionObjectEmployeeUpdateAfter');

    return true;
}
