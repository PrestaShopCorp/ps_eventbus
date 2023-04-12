<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

class StoreDecorator
{
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;
    /**
     * @var string
     */
    private $timezone;

    public function __construct(
        ConfigurationRepository $configurationRepository
    ) {
        $this->configurationRepository = $configurationRepository;
        $this->timezone = (string) $this->configurationRepository->get('PS_TIMEZONE');
    }

    /**
     * @param array $stores
     *
     * @return void
     */
    public function decorateStores(array &$stores)
    {
        foreach ($stores as &$store) {
            $this->castPropertyValues($store);
        }
    }

    /**
     * @param array $store
     *
     * @return void
     */
    private function castPropertyValues(array &$store)
    {
        $store['id_store'] = (int) $store['id_store'];
        $store['id_country'] = (int) $store['id_country'];
        $store['id_state'] = (int) $store['id_state'];
        $store['active'] = (bool) $store['active'];
        $store['id_lang'] = (int) $store['id_lang'];
        $store['id_shop'] = (int) $store['id_shop'];

        $store['created_at'] = (new \DateTime($store['created_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
        $store['updated_at'] = (new \DateTime($store['updated_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
    }
}
