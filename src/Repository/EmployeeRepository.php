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

    public function __construct(\Db $db, \Context $context)
    {
        $this->db = $db;
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

        $query->where('c.id_shop = ' . $shopId);

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
            (array)$query,
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
        $query->select('e.id_employee,
            e.id_profile,
            e.id_lang,
            e.email,
            e.bo_color,
            e.bo_theme,
            e.bo_css,
            e.default_tab,
            e.bo_width,
            e.bo_menu,
            e.active,
            e.optin,
            e.id_last_order,
            e.id_last_customer_message,
            e.id_last_customer,
            e.last_connection_date,
            e.has_enabled_gravatar
        ');

        $query->select('es.id_shop as id_shop');
    }
}
