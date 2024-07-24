<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class StoreDecorator
{
    /**
     * @param array<mixed> $stores
     *
     * @return void
     */
    public function decorateStores(&$stores)
    {
        foreach ($stores as &$store) {
            $this->castPropertyValues($store);
        }
    }

    /**
     * @param array<mixed> $store
     *
     * @return void
     */
    private function castPropertyValues(&$store)
    {
        $store['id_store'] = (int) $store['id_store'];
        $store['id_country'] = (int) $store['id_country'];
        $store['id_state'] = (int) $store['id_state'];
        $store['active'] = (bool) $store['active'];

        // https://github.com/PrestaShop/PrestaShop/commit/7dda2be62d8bd606edc269fa051c36ea68f81682#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2004
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
            $store['id_lang'] = (int) $store['id_lang'];
            $store['id_shop'] = (int) $store['id_shop'];
        }

        $store['created_at'] = (string) $store['created_at'];
        $store['updated_at'] = (string) $store['updated_at'];
    }
}
