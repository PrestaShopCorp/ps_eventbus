<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ModuleRepository
{
    public const MODULE_TABLE = 'module';
    public const MODULE_TABLE_HISTORY = 'module_history';
    public const MODULE_SHOP = 'module_shop';

    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        return (new \DbQuery())
          ->from(self::MODULE_TABLE, 'm')
          ->leftJoin(self::MODULE_TABLE_HISTORY, 'h', 'm.id_module = h.id_module')
          ->leftJoin(self::MODULE_SHOP, 'm_shop', 'm.id_module = m_shop.id_module');
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

        /*
         * The `active` field of the "ps_module" table has been deprecated, this is why we use the "ps_module_shop" table
         * to check if a module is active or not
        */
        $query->select('m.id_module as module_id, name, version as module_version, IF(m_shop.enable_device, 1, 0) as active, date_add as created_at, date_upd as updated_at')
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
