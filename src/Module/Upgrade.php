<?php

namespace PrestaShop\Module\Ps_eventbus\Module;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use Ps_eventbus;

class Upgrade
{
    /**
     * @var Ps_eventbus
     */
    private $module;

    /**
     * Install constructor.
     *
     * @param Ps_eventbus $module
     *
     * @return void
     */
    public function __construct(Ps_eventbus $module)
    {
        $this->module = $module;
    }

    /**
     * Upgrade ps_eventbus module
     *
     * @return bool
     */
    public function upgradePsEventbus()
    {
        if (true === \Module::needUpgrade($this->module)) {
            /** @var ModuleManagerBuilder $moduleManagerBuilder */
            $moduleManagerBuilder = ModuleManagerBuilder::getInstance();
            $moduleManager = $moduleManagerBuilder->build();

            return $moduleManager->upgrade((string) $this->module->name);
        }

        return true;
    }
}
