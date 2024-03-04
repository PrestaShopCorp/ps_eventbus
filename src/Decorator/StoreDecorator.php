<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class StoreDecorator
{
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
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $store['id_lang'] = (int) $store['id_lang'];
            $store['id_shop'] = (int) $store['id_shop'];
        } // TODO: statusCode:465 for PS 1.6 here, what should we set in the else ?

        $store['created_at'] = (string) $store['created_at'];
        $store['updated_at'] = (string) $store['updated_at'];
    }
}
