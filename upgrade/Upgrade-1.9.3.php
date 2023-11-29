<?php

/**
 * @param Ps_eventbus $module
 *
 * @return bool
 */
function upgrade_module_1_9_3($module)
{
    $module->registerhook('actionObjectCurrencyAddAfter');
    $module->registerhook('actionObjectCurrencyUpdateAfter');

    return true;
}
