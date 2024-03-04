<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class LanguageDecorator
{
    /**
     * @param array $languages
     *
     * @return void
     */
    public function decorateLanguages(array &$languages)
    {
        foreach ($languages as &$language) {
            $this->castPropertyValues($language);
        }
    }

    /**
     * @param array $language
     *
     * @return void
     */
    private function castPropertyValues(array &$language)
    {
        $language['id_lang'] = (int) $language['id_lang'];
        $language['active'] = (bool) $language['active'];
        $language['is_rtl'] = (bool) $language['is_rtl'];
        $language['id_shop'] = (int) $language['id_shop'];
    }
}
