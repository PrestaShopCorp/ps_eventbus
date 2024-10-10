<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Module;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Uninstall
{
    /**
     * @var \Ps_eventbus
     */
    private $module;
    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Ps_eventbus $module, \Db $db)
    {
        $this->module = $module;
        $this->db = $db;
    }

    /**
     * uninstallMenu.
     *
     * @return bool
     */
    public function uninstallMenu()
    {
        // foreach( ['configure', 'hmac', 'ajax'] as $aliasController){
        foreach ($this->module->adminControllers as $controllerName) {
            $tabId = (int) \Tab::getIdFromClassName($controllerName);

            if (!$tabId) {
                return true;
            }

            $tab = new \Tab($tabId);

            return $tab->delete();
        }

        return true;
    }

    /**
     * @return bool
     */
    public function uninstallDatabaseTables()
    {
        $dbUninstallFile = "{$this->module->getLocalPath()}/sql/uninstall.sql";

        if (!file_exists($dbUninstallFile)) {
            return false;
        }

        $sql = \Tools::file_get_contents($dbUninstallFile);

        if (empty($sql) || !is_string($sql)) {
            return false;
        }

        $sql = str_replace(['PREFIX_', 'ENGINE_TYPE'], [_DB_PREFIX_, _MYSQL_ENGINE_], $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));

        if (!empty($sql)) {
            foreach ($sql as $query) {
                if (!$this->db->execute($query)) {
                    return false;
                }
            }
        }

        return true;
    }
}
