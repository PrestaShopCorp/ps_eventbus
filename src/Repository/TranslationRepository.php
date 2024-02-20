<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\PrestaShop\Adapter\Entity\Context;
use PrestaShop\PrestaShop\Adapter\Entity\Db;
use PrestaShop\PrestaShop\Adapter\Entity\DbQuery;
use PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException;
use PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException;

class TranslationRepository
{
    /**
     * @var Db
     */
    private $db;

    /**
     * @var Context
     */
    private $context;

    public function __construct(Context $context)
    {
        $this->db = Db::getInstance();
        $this->context = $context;
    }

    /**
     * @return DbQuery
     */
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new DbQuery();
        $query->from('translation', 'c')
            ->where('c.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws PrestaShopDatabaseException
     */
    public function getTranslations($offset, $limit)
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
    public function getRemainingTranslationsCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(c.id_translation) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $translationIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws PrestaShopDatabaseException
     */
    public function getTranslationsIncremental($limit, $translationIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('c.id_translation IN(' . implode(',', array_map('intval', $translationIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(DbQuery $query)
    {
        $query->select('c.id_translation, c.id_lang, c.key, c.translation, c.domain, c.theme');
    }
}
