<?php

/**
 * @param Ps_eventbus $module
 *
 * @return bool
 */
function upgrade_module_1_5_2($module)
{
    $module->registerhook('actionObjectSpecificPriceAddAfter');
    $module->registerhook('actionObjectSpecificPriceUpdateAfter');
    $module->registerhook('actionObjectSpecificPriceDeleteAfter');

    return true;
}
