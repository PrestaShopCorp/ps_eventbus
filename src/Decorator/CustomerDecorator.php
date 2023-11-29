<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

class CustomerDecorator
{
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;

    public function __construct(
        ConfigurationRepository $configurationRepository
    ) {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * @param array $customers
     *
     * @return void
     */
    public function decorateCustomers(array &$customers)
    {
        foreach ($customers as &$customer) {
            $this->castPropertyValues($customer);
            $this->hashEmail($customer);
        }
    }

    /**
     * @param array $customer
     *
     * @return void
     */
    private function castPropertyValues(array &$customer)
    {
        $customer['id_customer'] = (int) $customer['id_customer'];
        $customer['id_lang'] = (int) $customer['id_lang'];

        $customer['newsletter'] = (bool) $customer['newsletter'];

        $timezone = (string) $this->configurationRepository->get('PS_TIMEZONE');
        $customer['newsletter_date_add'] = (new \DateTime($customer['newsletter_date_add'], new \DateTimeZone($timezone)))->format('Y-m-d\TH:i:sO');

        $customer['optin'] = (bool) $customer['optin'];
        $customer['active'] = (bool) $customer['active'];
        $customer['is_guest'] = (bool) $customer['is_guest'];
        $customer['deleted'] = (bool) $customer['deleted'];
    }

    /**
     * @param array $customer
     *
     * @return void
     */
    private function hashEmail(array &$customer)
    {
        $customer['email_hash'] = hash('sha256', $customer['email'] . 'dUj4GMBD6689pL9pyr');
        unset($customer['email']);
    }
}
