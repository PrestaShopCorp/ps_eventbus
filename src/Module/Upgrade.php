<?php

namespace PrestaShop\Module\Ps_eventbus\Module;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use Prestashop\ModuleLibMboInstaller\Presenter as MBOPresenter;
use Prestashop\ModuleLibMboInstaller\Installer as MBOInstaller;
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
        $mboStatus = (new MBOPresenter)->present();

        if ($mboStatus['isInstalled'] == false && $mboStatus['isEnabled']) {
            try {
                $mboInstaller = new MBOInstaller(_PS_VERSION_);
                $mboInstaller->installModule();
            } catch (\Exception $e) {
                throw new \Exception('Error while installing MBO module');
            }
        }

        if (true === \Module::needUpgrade($this->module)) {
            /** @var ModuleManagerBuilder $moduleManagerBuilder */
            $moduleManagerBuilder = ModuleManagerBuilder::getInstance();
            $moduleManager = $moduleManagerBuilder->build();

            return $moduleManager->upgrade((string) $this->module->name);
        }

        return true;
    }
}
