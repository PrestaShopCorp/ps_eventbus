<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class EmployeeRepository
{
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;
    }

    /**
     * @return \DbQuery
     */
    private function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $dbQuery = new \DbQuery();

        $dbQuery->from('employee', 'e')
            ->leftJoin('employee_shop', 'es', 'es.id_employee = e.id_employee');

        $dbQuery->where('es.id_shop = ' . $shopId);

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getEmployees($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingEmployeesCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(e.id_employee) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $employeeIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getEmployeesIncremental($limit, $employeeIds)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('e.id_employee IN(' . implode(',', array_map('intval', $employeeIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('e.id_employee');
        $dbQuery->select('e.id_profile');
        $dbQuery->select('e.id_lang');
        $dbQuery->select('e.email');
        $dbQuery->select('e.bo_color');
        $dbQuery->select('e.bo_theme');
        $dbQuery->select('e.bo_css');
        $dbQuery->select('e.default_tab');
        $dbQuery->select('e.bo_width');
        $dbQuery->select('e.bo_menu');
        $dbQuery->select('e.active');
        $dbQuery->select('e.optin');
        $dbQuery->select('e.id_last_order');
        $dbQuery->select('e.id_last_customer_message');
        $dbQuery->select('e.id_last_customer');
        $dbQuery->select('e.last_connection_date');
        $dbQuery->select('es.id_shop as id_shop');

        // https://github.com/PrestaShop/PrestaShop/commit/20f1d9fe8a03559dfa9d1f7109de1f70c99f1874#diff-cde6a9d4a58afb13ff068801ee09c0e712c5e90b0cbf5632a0cc965f15cb6802R107
        if (version_compare(_PS_VERSION_, '1.7.8.0', '>=')) {
            $dbQuery->select('e.has_enabled_gravatar');
        }
    }
}
