<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class TranslationDecorator
{
    /**
     * @param array<mixed> $translations
     *
     * @return void
     */
    public function decorateTranslations(&$translations)
    {
        foreach ($translations as &$translation) {
            $this->castPropertyValues($translation);
        }
    }

    /**
     * @param array<mixed> $translation
     *
     * @return void
     */
    private function castPropertyValues(&$translation)
    {
        $translation['id_translation'] = (int) $translation['id_translation'];
        $translation['id_lang'] = (int) $translation['id_lang'];
        $translation['key'] = (string) $translation['key'];
        $translation['translation'] = (string) $translation['translation'];
        $translation['domain'] = (string) $translation['domain'];
        $translation['theme'] = (string) $translation['theme'];
    }
}
