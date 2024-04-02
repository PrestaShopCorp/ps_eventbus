<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class LanguageRepository
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
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getLanguagesSync($offset, $limit)
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
    public function getRemainingLanguagesCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(la.id_lang) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $languageIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getLanguagesIncremental($limit, $languageIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('la.id_lang IN(' . implode(',', array_map('intval', $languageIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new \DbQuery();
        $query->from('lang', 'la')
            ->innerJoin('lang_shop', 'las', 'la.id_lang = las.id_lang AND las.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('la.id_lang, la.name, la.active, la.iso_code, la.language_code, la.locale, la.date_format_lite');
        $query->select('la.date_format_full, la.is_rtl, las.id_shop');
    }

    /**
     * @return array
     */
    public function getLanguagesIsoCodes()
    {
        /** @var array $languages */
        $languages = \Language::getLanguages();

        return array_map(function ($language) {
            return $language['iso_code'];
        }, $languages);
    }

    /**
     * @return string
     */
    public function getDefaultLanguageIsoCode()
    {
        $language = \Language::getLanguage((int) \Configuration::get('PS_LANG_DEFAULT'));

        if (is_array($language)) {
            return $language['iso_code'];
        }

        return '';
    }

    /**
     * @param string $isoCode
     *
     * @return int
     */
    public function getLanguageIdByIsoCode($isoCode)
    {
        return (int) \Language::getIdByIso($isoCode);
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return \Language::getLanguages();
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
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
}
