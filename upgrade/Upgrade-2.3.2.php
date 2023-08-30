<?php

/**
 * @return bool
 */
function upgrade_module_2_3_2($module)
{
    $module->registerhook('actionObjectLanguageAddAfter');
    $module->registerhook('actionObjectLanguageDeleteAfter');
    $module->registerhook('actionObjectLanguageUpdateAfter');

    return true;
}
