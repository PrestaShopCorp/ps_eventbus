<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Controller\Admin;

use PrestaShop\Module\PsEventbus\Module\Upgrade;
use Prestashop\ModuleLibMboInstaller\Installer as MBOInstaller;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PsEventbusResolverController extends FrameworkBundleAdminController
{
    /** @var \Ps_eventbus */
    private $module;

    public function __construct()
    {
        /** @var \Ps_eventbus $psEventbus */
        $psEventbus = \Module::getInstanceByName('ps_eventbus');
        $this->module = $psEventbus;
    }

    /**
     * Api endpoint
     *
     * @param Request $request
     * @param string $query
     *
     * @return Response
     *
     * @@throws \Exception
     */
    public function resolve(Request $request, string $query)
    {
        try {
            if (is_callable([$this, $query])) {
                /** @var callable $args */
                $args = [$this, $query];

                /** @var Response $result */
                $result = call_user_func($args);

                return $result;
            }
        } catch (\Throwable $th) {
            throw new \Exception('#001 Message : ' . $th->getMessage());
        }

        return new Response('Not found', 404);
    }

    /**
     * Install ps_mbo module
     *
     * @return Response
     */
    public function installPsMbo(): Response
    {
        $mboInstaller = new MBOInstaller(_PS_VERSION_);

        return new JsonResponse($mboInstaller->installModule(), 200);
    }

    /**
     * Upgrade a module
     *
     * @return Response
     */
    public function upgradeModule()
    {
        /** @var Upgrade $upgrade */
        $upgrade = $this->module->getService('ps_eventbus.module.upgrade');

        return new Response($upgrade->upgradePsEventbus(), 200, [
            'Content-Type' => 'application/json',
        ]);
    }
}
