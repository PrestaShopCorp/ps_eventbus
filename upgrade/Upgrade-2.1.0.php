<?php

/**
 * @return bool
 */
function upgrade_module_2_1_0($module)
{
    $module->registerhook('actionObjectImageAddAfter');
    $module->registerhook('actionObjectImageDeleteAfter');
    $module->registerhook('actionObjectImageUpdateAfter');

    return true;
}
