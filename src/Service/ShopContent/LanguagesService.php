<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\LanguageRepository;

class LanguagesService implements ShopContentServiceInterface
{
    /** @var LanguageRepository */
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->languageRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castLanguages($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_lang'],
                'collection' => Config::COLLECTION_LANGUAGES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->languageRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castLanguages($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_lang'],
                'collection' => Config::COLLECTION_LANGUAGES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->languageRepository->countFullSyncContentLeft($offset, $limit, $langIso);
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
     * @param array<mixed> $languages
     *
     * @return void
     */
    private function castLanguages(&$languages)
    {
        foreach ($languages as &$language) {
            $language['id_lang'] = (int) $language['id_lang'];
            $language['active'] = (bool) $language['active'];
            $language['is_rtl'] = (bool) $language['is_rtl'];
            $language['id_shop'] = (int) $language['id_shop'];
        }
    }
}
