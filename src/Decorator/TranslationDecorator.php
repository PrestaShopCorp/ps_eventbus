<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class TranslationDecorator
{
    /**
     * @param array $translations
     *
     * @return void
     */
    public function decorateTranslations(array &$translations)
    {
        foreach ($translations as &$translation) {
            $this->castPropertyValues($translation);
        }
    }

    /**
     * @param array $translation
     *
     * @return void
     */
    private function castPropertyValues(array &$translation)
    {
        $translation['id_translation'] = (int) $translation['id_translation'];
        $translation['id_lang'] = (int) $translation['id_lang'];
        $translation['key'] = (string) $translation['key'];
        $translation['translation'] = (string) $translation['translation'];
        $translation['domain'] = (string) $translation['domain'];
        $translation['theme'] = (string) $translation['theme'];
    }
}
