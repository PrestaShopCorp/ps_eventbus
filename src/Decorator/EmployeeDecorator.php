<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class EmployeeDecorator
{
    /**
     * @param array<mixed> $employees
     *
     * @return void
     */
    public function decorateEmployees(&$employees)
    {
        foreach ($employees as &$employee) {
            $this->castPropertyValues($employee);
            $this->hashEmail($employee);
        }
    }

    /**
     * @param array<mixed> $employee
     *
     * @return void
     */
    private function castPropertyValues(&$employee)
    {
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
    }

    /**
     * @param array<mixed> $employee
     *
     * @return void
     */
    private function hashEmail(&$employee)
    {
        // FIXME : use a random salt generated during module install
        $employee['email_hash'] = hash('sha256', $employee['email'] . 'dUj4GMBD6689pL9pyr');
        unset($employee['email']);
    }
}
