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
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getManufacturers($offset, $limit, $langIso)
    {
        $query = $this->getBaseQuery($langIso);

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
        $query = $this->getBaseQuery($langIso)
            ->select('(COUNT(ma.id_manufacturer) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $manufacturerIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getManufacturersIncremental($limit, $langIso, $manufacturerIds)
    {
        $query = $this->getBaseQuery($langIso);

        $this->addSelectParameters($query);

        $query->where('ma.id_manufacturer IN(' . implode(',', array_map('intval', $manufacturerIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
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
        $query = new \DbQuery();
        $query->from('manufacturer', 'ma')
            ->innerJoin('manufacturer_lang', 'mal', 'ma.id_manufacturer = mal.id_manufacturer AND mal.id_lang = ' . (int) $langId)
            ->innerJoin('manufacturer_shop', 'mas', 'ma.id_manufacturer = mas.id_manufacturer AND mas.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        $query = $this->getBaseQuery($langIso);

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
        $query->select('ma.id_manufacturer, ma.name, ma.date_add as created_at, ma.date_upd as updated_at, ma.active, mal.id_lang');
        $query->select('mal.description, mal.short_description, mal.meta_title, mal.meta_description, mas.id_shop');

        // REMOVED HERE: https://github.com/PrestaShop/PrestaShop/commit/f37a8f61017654bae160b528a1a2eaf49edbdac0
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '9.0', '<')) {
            $query->select('mal.meta_keywords');
        }
    }
}
