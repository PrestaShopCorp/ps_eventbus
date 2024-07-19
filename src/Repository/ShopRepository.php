<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ShopRepository
{
    /**
     * @var \Db
     */
    private $db;

    public function __construct()
    {
        $this->db = \Db::getInstance();
    }

    /**
     * @return int
     */
    public function getMultiShopCount()
    {
        $dbQuery = new \DbQuery();

        $dbQuery->select('COUNT(id_shop)')
            ->from('shop')
            ->where('active = 1 and deleted = 0');

        return (int) $this->db->getValue($dbQuery);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        $dbQuery = new \DbQuery();

        $dbQuery->select('date_add as created_at')
          ->from('configuration')
          ->where('name = "PS_INSTALL_VERSION"');

        return (string) $this->db->getValue($dbQuery);
    }

    /**
     * Gives back the first iso_code registered, which correspond to the default country of this shop
     *
     * @return string
     */
    public function getShopCountryCode()
    {
        $dbQuery = new \DbQuery();

        $dbQuery->select('iso_code')
          ->from('country')
          ->where('active = 1');

        return (string) $this->db->getValue($dbQuery);
    }
}
