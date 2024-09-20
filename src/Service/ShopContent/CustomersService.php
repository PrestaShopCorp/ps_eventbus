<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CustomerRepository;

class CustomersService implements ShopContentServiceInterface
{
    /** @var CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
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
        $result = $this->customerRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCustomers($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_customer'],
                'collection' => Config::COLLECTION_CUSTOMERS,
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
        $result = $this->customerRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCustomers($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_customer'],
                'collection' => Config::COLLECTION_CUSTOMERS,
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
        return $this->customerRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $customers
     *
     * @return void
     */
    private function castCustomers(&$customers)
    {
        foreach ($customers as &$customer) {
            $customer['id_customer'] = (int) $customer['id_customer'];
            $customer['id_lang'] = (int) $customer['id_lang'];
            $customer['newsletter'] = (bool) $customer['newsletter'];
            $customer['newsletter_date_add'] = (string) $customer['newsletter_date_add'];
            $customer['optin'] = (bool) $customer['optin'];
            $customer['active'] = (bool) $customer['active'];
            $customer['is_guest'] = (bool) $customer['is_guest'];
            $customer['deleted'] = (bool) $customer['deleted'];

            $customer['email_hash'] = hash('sha256', $customer['email'] . 'dUj4GMBD6689pL9pyr');
            unset($customer['email']);
        }
    }
}
