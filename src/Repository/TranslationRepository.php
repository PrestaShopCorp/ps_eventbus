<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class TranslationRepository
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
     * @param int $shopId
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId)
    {
        $query = new \DbQuery();
        $query->from('translation', 'c')
            ->where('c.id_shop = ' . (int) $shopId);

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
    public function getTranslations($offset, $limit)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingTranslationsCount($offset)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId)
            ->select('(COUNT(c.id_translation) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $translationIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getTranslationsIncremental($limit, $translationIds)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId);

        $this->addSelectParameters($query);

        $query->where('c.id_translation IN(' . implode(',', array_map('intval', $translationIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('c.id_translation, c.id_lang, c.key, c.translation, c.domain, c.theme');
    }
}
