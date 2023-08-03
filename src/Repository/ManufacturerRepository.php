<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ManufacturerRepository
{
    /**
     * @var \Db
     */
    private $db;

    /**
     * @var \Context
     */
    private $context;

    public function __construct(\Db $db, \Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getManufacturers($offset, $limit, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingManufacturersCount($offset, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso)
            ->select('(COUNT(ma.id_manufacturer) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $manufacturerIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getManufacturersIncremental($limit, $langIso, $manufacturerIds)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso);

        $this->addSelectParameters($query);

        $query->where('ma.id_manufacturer IN(' . implode(',', array_map('intval', $manufacturerIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $shopId
     * @param string $langIso
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId, $langIso)
    {
        /** @var int $langId */
        $langId = (int) \Language::getIdByIso($langIso);
        $query = new \DbQuery();
        $query->from('manufacturer', 'ma')
            ->innerJoin('manufacturer_lang', 'mal', 'ma.id_manufacturer = mal.id_manufacturer AND mal.id_lang = ' . (int) $langId)
            ->innerJoin('manufacturer_shop', 'mas', 'ma.id_manufacturer = mas.id_manufacturer AND mas.id_shop = ' . (int) $shopId);

        return $query;
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('ma.id_manufacturer, ma.name, ma.date_add as created_at, ma.date_upd as updated_at, ma.active, mal.id_lang,
      mal.description, mal.short_description, mal.meta_title, mal.meta_keywords, mal.meta_description, mas.id_shop');
    }
}
