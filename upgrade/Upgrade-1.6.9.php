<?php

/**
 * @param Ps_eventbus $module
 *
 * @return bool
 */
function upgrade_module_1_6_9($module)
{
    $module->registerhook('actionObjectCombinationDeleteAfter');

    return true;
}
