<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class EmployeeDecorator
{
    /**
     * @param array $employees
     *
     * @return void
     */
    public function decorateEmployees(array &$employees)
    {
        foreach ($employees as &$employee) {
            $this->castPropertyValues($employee);
            $this->hashEmail($employee);
        }
    }

    /**
     * @param array $employee
     *
     * @return void
     */
    private function castPropertyValues(array &$employee)
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

        $employee['has_enabled_gravatar'] = (bool) $employee['has_enabled_gravatar'];

        $employee['last_connection_date'] = (string) $employee['last_connection_date'];

        $employee['id_shop'] = (int) $employee['id_shop'];
    }

    /**
     * @param array $employee
     *
     * @return void
     */
    private function hashEmail(array &$employee)
    {
        // FIXME : use a random salt generated during module install
        $employee['email_hash'] = hash('sha256', $employee['email'] . 'dUj4GMBD6689pL9pyr');
        unset($employee['email']);
    }
}
