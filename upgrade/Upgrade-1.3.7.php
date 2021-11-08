<?php

/**
 * @param Ps_eventbus $module
 *
 * @return bool
 */
function upgrade_module_1_3_7($module)
{
    $module->registerhook('actionObjectCarrierAddAfter');
    $module->registerhook('actionObjectCarrierUpdateAfter');
    $module->registerhook('actionObjectCarrierDeleteAfter');
    $module->registerhook('actionObjectCountryAddAfter');
    $module->registerhook('actionObjectCountryUpdateAfter');
    $module->registerhook('actionObjectCountryDeleteAfter');
    $module->registerhook('actionObjectStateAddAfter');
    $module->registerhook('actionObjectStateUpdateAfter');
    $module->registerhook('actionObjectStateUpdateAfter');
    $module->registerhook('actionObjectZoneAddAfter');
    $module->registerhook('actionObjectZoneUpdateAfter');
    $module->registerhook('actionObjectZoneDeleteAfter');
    $module->registerhook('actionObjectTaxAddAfter');
    $module->registerhook('actionObjectTaxUpdateAfter');
    $module->registerhook('actionObjectTaxDeleteAfter');
    $module->registerhook('actionObjectTaxRulesGroupAddAfter');
    $module->registerhook('actionObjectTaxRulesGroupUpdateAfter');
    $module->registerhook('actionObjectTaxRulesGroupDeleteAfter');
    $module->registerhook('actionShippingPreferencesPageSave');

    return true;
}
