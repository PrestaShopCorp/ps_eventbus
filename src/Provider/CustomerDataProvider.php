<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\CustomerDecorator;
use PrestaShop\Module\PsEventbus\Repository\CustomerRepository;

class CustomerDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;
    /**
     * @var CustomerDecorator
     */
    private $customerDecorator;

    public function __construct(CustomerRepository $customerRepository, CustomerDecorator $customerDecorator)
    {
        $this->customerRepository = $customerRepository;
        $this->customerDecorator = $customerDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $customers = $this->customerRepository->getCustomers($offset, $limit, $langIso);

        if (!is_array($customers)) {
            return [];
        }

        $this->customerDecorator->decorateCustomers($customers);

        return array_map(function ($customer) {
            return [
                'id' => "{$customer['id_customer']}",
                'collection' => Config::COLLECTION_CUSTOMERS,
                'properties' => $customer,
            ];
        }, $customers);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->customerRepository->getRemainingCustomersCount($offset, $langIso);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $objectIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $customers = $this->customerRepository->getCustomersIncremental($limit, $langIso, $objectIds);

        if (!is_array($customers)) {
            return [];
        }

        $this->customerDecorator->decorateCustomers($customers);

        return array_map(function ($customer) {
            return [
                'id' => "{$customer['id_customer']}",
                'collection' => Config::COLLECTION_CUSTOMERS,
                'properties' => $customer,
            ];
        }, $customers);
    }
}
