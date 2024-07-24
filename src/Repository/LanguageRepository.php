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
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
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
     * @param array<mixed> $languageIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
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
        // https://github.com/PrestaShop/PrestaShop/commit/481111b8274ed005e1c4a8ce2cf2b3ebbeb9a270#diff-c123d3d30d9c9e012a826a21887fccce6600a2f2a848a58d5910e55f0f8f5093R41
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            $query->select('la.locale');
        }

        $query->select('la.id_lang, la.name, la.active, la.iso_code, la.language_code, la.date_format_lite');
        $query->select('la.date_format_full, la.is_rtl, las.id_shop');
    }

    /**
     * @return array<mixed>
     */
    public function getLanguagesIsoCodes()
    {
        /** @var array<mixed> $languages */
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
     * @return array<mixed>
     */
    public function getLanguages()
    {
        return \Language::getLanguages();
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
}
