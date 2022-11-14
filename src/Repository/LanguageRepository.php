<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class LanguageRepository
{
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
}
