<?php

/**
 * @return bool
 */
function upgrade_module_1_10_3($module)
{
    $module->registerhook('actionObjectWishlistAddAfter');
    $module->registerhook('actionObjectWishlistUpdateAfter');
    $module->registerhook('actionObjectWishlistDeleteAfter');

    return true;
}
