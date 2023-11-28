<?php

namespace PrestaShop\Module\Ps_eventbus\Helper;

use PrestaShopBundle\Service\Routing\Router;
use Ps_eventbus;
use Prestashop\ModuleLibMboInstaller\Presenter as MBOPresenter;
use Prestashop\ModuleLibMboInstaller\Installer as MBOInstaller;

class ModuleHelper
{
    /** @var Ps_eventbus */
    private $module;

    public function __construct(Ps_eventbus $module)
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

    private function checkIfPsMBOIsInstalled()
    {
        $mboStatus = (new MBOPresenter)->present();

        return $mboStatus['isInstalled'] == false && $mboStatus['isEnabled'];
    }

    private function installPsMBO()
    {
        try {
            $mboInstaller = new MBOInstaller(_PS_VERSION_);
            $mboInstaller->installModule();
        } catch (\Exception $e) {
            throw new \Exception('Error while installing MBO module');
        }
    }
}
