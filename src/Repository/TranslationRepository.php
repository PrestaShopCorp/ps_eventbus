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

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;
    }

    /**
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $query = new \DbQuery();
        $query->from('translation', 't');

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
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
            ->select('(COUNT(t.id_translation) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array<mixed> $translationIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getTranslationsIncremental($limit, $translationIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('t.id_translation IN(' . implode(',', array_map('intval', $translationIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
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
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('t.id_translation, t.id_lang, t.key, t.translation, t.domain, t.theme');
    }
}
