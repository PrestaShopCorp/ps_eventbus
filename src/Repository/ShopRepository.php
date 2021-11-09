<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Context;
use Db;
use DbQuery;

class ShopRepository
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var Db
     */
    private $db;

    public function __construct(Context $context, Db $db)
    {
        $this->context = $context;
        $this->db = $db;
    }

    /**
     * @return int
     */
    public function getMultiShopCount()
    {
        $query = new DbQuery();

        $query->select('COUNT(id_shop)')
            ->from('shop')
            ->where('active = 1 and deleted = 0');

        return (int) $this->db->getValue($query);
    }

    public function getCreatedAt()
    {
        $query = new DbQuery();

        $query->select('date_add as created_at')
          ->from('configuration')
          ->where('name = "PS_INSTALL_VERSION"');

        return (string) $this->db->getValue($query);
    }
}
