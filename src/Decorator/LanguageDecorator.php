<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\ShopRepository;

class LanguageDecorator
{
    /**
     * @var string
     */
    private $timezone;

    /**
     * @var string
     */
    private $createdAt;

    public function __construct(
        ConfigurationRepository $configurationRepository,
        ShopRepository $shopRepository
    ) {
        $this->timezone = (string) $configurationRepository->get('PS_TIMEZONE');
        $this->createdAt = $shopRepository->getCreatedAt();
    }

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
        $language['created_at'] = (new \DateTime($this->createdAt, new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
        $language['updated_at'] = (new \DateTime($this->createdAt, new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
    }
}
