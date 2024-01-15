<?php

/**
 * @return bool
 */
function upgrade_module_2_3_6($module)
{
  $module->registerhook('actionObjectCartRuleAddAfter');
  $module->registerhook('actionObjectCartRuleDeleteAfter');
  $module->registerhook('actionObjectCartRuleUpdateAfter');

  return true;
}
