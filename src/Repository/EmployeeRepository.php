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

        $query = new \DbQuery();

        $query->from('employee', 'e')
            ->leftJoin('employee_shop', 'es', 'es.id_employee = e.id_employee');

        $query->where('es.id_shop = ' . $shopId);

        return $query;
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
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
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
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('e.id_employee IN(' . implode(',', array_map('intval', $employeeIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
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
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('e.id_employee');
        $query->select('e.id_profile');
        $query->select('e.id_lang');
        $query->select('e.email');
        $query->select('e.bo_color');
        $query->select('e.bo_theme');
        $query->select('e.bo_css');
        $query->select('e.default_tab');
        $query->select('e.bo_width');
        $query->select('e.bo_menu');
        $query->select('e.active');
        $query->select('e.optin');
        $query->select('e.id_last_order');
        $query->select('e.id_last_customer_message');
        $query->select('e.id_last_customer');
        $query->select('e.last_connection_date');
        $query->select('e.has_enabled_gravatar');

        $query->select('es.id_shop as id_shop');
    }
}
