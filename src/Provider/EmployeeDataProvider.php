<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\EmployeeDecorator;
use PrestaShop\Module\PsEventbus\Repository\EmployeeRepository;

class EmployeeDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;
    /**
     * @var EmployeeDecorator
     */
    private $employeeDecorator;

    public function __construct(EmployeeRepository $employeeRepository, EmployeeDecorator $employeeDecorator)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeDecorator = $employeeDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $employees = $this->employeeRepository->getEmployees($offset, $limit);

        if (!is_array($employees)) {
            return [];
        }

        $this->employeeDecorator->decorateEmployees($employees);

        return array_map(function ($employee) {
            return [
                'id' => "{$employee['id_employee']}",
                'collection' => Config::COLLECTION_EMPLOYEES,
                'properties' => $employee,
            ];
        }, $employees);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->employeeRepository->getRemainingEmployeesCount($offset);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $objectIds
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $employees = $this->employeeRepository->getEmployeesIncremental($limit, $objectIds);

        if (!is_array($employees)) {
            return [];
        }

        $this->employeeDecorator->decorateEmployees($employees);

        return array_map(function ($employee) {
            return [
                'id' => "{$employee['id_customer']}",
                'collection' => Config::COLLECTION_EMPLOYEES,
                'properties' => $employee,
            ];
        }, $employees);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->employeeRepository->getQueryForDebug($offset, $limit);
    }
}
