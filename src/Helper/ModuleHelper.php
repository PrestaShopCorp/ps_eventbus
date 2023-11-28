<?php

namespace PrestaShop\Module\Ps_eventbus\Helper;

use Prestashop\ModuleLibMboInstaller\Installer as MBOInstaller;
use Prestashop\ModuleLibMboInstaller\Presenter as MBOPresenter;
use PrestaShopBundle\Service\Routing\Router;

class ModuleHelper
{
    /** @var \Ps_eventbus */
    private $module;

    public function __construct(\Ps_eventbus $module)
    {
        $this->module = $module;
    }

    /**
     * returns the update link of the module if it is not enabled. If enabled, returns an empty string
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function getUpdateLink(string $moduleName)
    {
        if ($this->checkIfPsMBOIsInstalled()) {
            $this->installPsMBO();
        }

        /** @var Router $router * */
        $router = $this->module->getService('router');

        return substr(\Tools::getShopDomainSsl(true) . __PS_BASE_URI__, 0, -1) .
            $router->generate('admin_module_manage_action', [
                'action' => 'upgrade',
                'module_name' => $moduleName,
            ]);
    }

    /**
     * Check if Ps_Mbo is installed
     * 
     * @return bool
     */
    private function checkIfPsMBOIsInstalled()
    {
        $mboStatus = (new MBOPresenter())->present();

        return $mboStatus['isInstalled'] == false && $mboStatus['isEnabled'];
    }

    /**
     * Install Ps_Mbo
     * 
     * @return bool
     */
    private function installPsMBO()
    {
        try {
            $mboInstaller = new MBOInstaller(_PS_VERSION_);
            return $mboInstaller->installModule();
        } catch (\Exception $e) {
            throw new \Exception('Error while installing MBO module');
        }
    }
}
