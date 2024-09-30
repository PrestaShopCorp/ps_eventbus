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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\EmployeeRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class EmployeesService implements ShopContentServiceInterface
{
    /** @var EmployeeRepository */
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->employeeRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castEmployees($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_employee'],
                'collection' => Config::COLLECTION_EMPLOYEES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->employeeRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castEmployees($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_employee'],
                'collection' => Config::COLLECTION_EMPLOYEES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->employeeRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $currencies
     *
     * @return void
     */
    private function castEmployees(&$currencies)
    {
        foreach ($currencies as &$employee) {
            $employee['id_employee'] = (int) $employee['id_employee'];
            $employee['id_profile'] = (int) $employee['id_profile'];
            $employee['id_lang'] = (int) $employee['id_lang'];

            $employee['default_tab'] = (int) $employee['default_tab'];
            $employee['bo_width'] = (int) $employee['bo_width'];
            $employee['bo_menu'] = (bool) $employee['bo_menu'];

            $employee['optin'] = (bool) $employee['optin'];
            $employee['active'] = (bool) $employee['active'];

            $employee['id_last_order'] = (int) $employee['id_last_order'];
            $employee['id_last_customer_message'] = (int) $employee['id_last_customer_message'];
            $employee['id_last_customer'] = (int) $employee['id_last_customer'];

            if ($employee['last_connection_date'] == '0000-00-00') {
                $employee['last_connection_date'] = null;
            } else {
                $employee['last_connection_date'] = (string) $employee['last_connection_date'];
            }

            $employee['id_shop'] = (int) $employee['id_shop'];

            // https://github.com/PrestaShop/PrestaShop/commit/20f1d9fe8a03559dfa9d1f7109de1f70c99f1874#diff-cde6a9d4a58afb13ff068801ee09c0e712c5e90b0cbf5632a0cc965f15cb6802R107
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.8.0', '>=')) {
                $employee['has_enabled_gravatar'] = (bool) $employee['has_enabled_gravatar'];
            }

            // FIXME : use a random salt generated during module install
            $employee['email_hash'] = hash('sha256', $employee['email'] . 'dUj4GMBD6689pL9pyr');
            unset($employee['email']);
        }
    }
}