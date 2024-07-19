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

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
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
        $dbQuery = $this->getBaseQuery($langIso);

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingManufacturersCount($offset, $langIso)
    {
        $query = $this->getBaseQuery($langIso)
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
        $dbQuery = $this->getBaseQuery($langIso);

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('ma.id_manufacturer IN(' . implode(',', array_map('intval', $manufacturerIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param string $langIso
     *
     * @return \DbQuery
     */
    public function getBaseQuery($langIso)
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        /** @var int $langId */
        $langId = (int) \Language::getIdByIso($langIso);
        $dbQuery = new \DbQuery();
        $dbQuery->from('manufacturer', 'ma')
            ->innerJoin('manufacturer_lang', 'mal', 'ma.id_manufacturer = mal.id_manufacturer AND mal.id_lang = ' . (int) $langId)
            ->innerJoin('manufacturer_shop', 'mas', 'ma.id_manufacturer = mas.id_manufacturer AND mas.id_shop = ' . $shopId);

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        $dbQuery = $this->getBaseQuery($langIso);

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
        $dbQuery->select('ma.id_manufacturer, ma.name, ma.date_add as created_at, ma.date_upd as updated_at, ma.active, mal.id_lang');
        $dbQuery->select('mal.description, mal.short_description, mal.meta_title, mal.meta_keywords, mal.meta_description, mas.id_shop');
    }
}
