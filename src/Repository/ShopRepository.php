<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ShopRepository
{
    /**
     * @var \PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return int
     */
    public function getMultiShopCount()
    {
        $query = new \PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

        $query->select('COUNT(id_shop)')
            ->from('shop')
            ->where('active = 1 and deleted = 0');

        return (int) $this->db->getValue($query);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        $query = new \PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

        $query->select('date_add as created_at')
          ->from('configuration')
          ->where('name = "PS_INSTALL_VERSION"');

        return (string) $this->db->getValue($query);
    }

    /**
     * Gives back the first iso_code registered, which correspond to the default country of this shop
     *
     * @return string
     */
    public function getShopCountryCode()
    {
        $query = new \PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

        $query->select('iso_code')
          ->from('country')
          ->where('active = 1');

        return (string) $this->db->getValue($query);
    }
}
