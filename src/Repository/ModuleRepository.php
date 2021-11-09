<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Db;
use DbQuery;

class ModuleRepository
{
    const MODULE_TABLE = 'module';
    const MODULE_TABLE_HISTORY = 'module_history';

    /**
     * @var Db
     */
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return DbQuery
     */
    public function getBaseQuery()
    {
        return (new DbQuery())
          ->from(self::MODULE_TABLE, 'm')
          ->leftJoin(self::MODULE_TABLE_HISTORY, 'h', 'm.id_module = h.id_module');
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|false|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getModules($offset, $limit)
    {
        $query = $this->getBaseQuery();

        $query->select('m.id_module as module_id, name, version as module_version, active, date_add as created_at, date_upd as updated_at')
            ->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingModules($offset)
    {
        $query = $this->getBaseQuery();

        $query->select('(COUNT(m.id_module) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }
}
