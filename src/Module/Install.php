<?php
/**
 * 2007-2020 PrestaShop and Contributors.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\PsEventbus\Module;

class Install
{
    const PARENT_TAB_NAME = -1;
    const TAB_ACTIVE = 0;

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
     * Installs database tables
     *
     * @return bool
     */
    public function installDatabaseTables()
    {
        $dbInstallFile = "{$this->module->getLocalPath()}/sql/install.sql";

        if (!file_exists($dbInstallFile)) {
            return false;
        }

        $sql = \Tools::file_get_contents($dbInstallFile);

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

        $this->copyDataFromPsAccounts();

        return true;
    }

    /**
     * @return void
     */
    private function copyDataFromPsAccounts()
    {
        $dbInstallFile = "{$this->module->getLocalPath()}/sql/migrate.sql";

        if (!file_exists($dbInstallFile)) {
            return;
        }

        $sql = \Tools::file_get_contents($dbInstallFile);

        if (empty($sql) || !is_string($sql)) {
            return;
        }

        $sql = str_replace(['PREFIX_', 'ENGINE_TYPE'], [_DB_PREFIX_, _MYSQL_ENGINE_], $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));

        if (!empty($sql)) {
            foreach ($sql as $query) {
                try {
                    $this->db->execute($query);
                } catch (\Exception $exception) {
                }
            }
        }
    }
}
