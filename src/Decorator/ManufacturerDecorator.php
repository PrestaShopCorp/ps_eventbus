<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class ManufacturerDecorator
{
    /**
     * @param array<mixed> $manufacturers
     *
     * @return void
     */
    public function decorateManufacturers(&$manufacturers)
    {
        foreach ($manufacturers as &$manufacturer) {
            $this->castPropertyValues($manufacturer);
        }
    }

    /**
     * @param array<mixed> $manufacturer
     *
     * @return void
     */
    private function castPropertyValues(&$manufacturer)
    {
        $manufacturer['id_manufacturer'] = (int) $manufacturer['id_manufacturer'];
        $manufacturer['active'] = (bool) $manufacturer['active'];
        $manufacturer['id_lang'] = (int) $manufacturer['id_lang'];
        $manufacturer['id_shop'] = (int) $manufacturer['id_shop'];
        $manufacturer['created_at'] = (string) $manufacturer['created_at'];
        $manufacturer['updated_at'] = (string) $manufacturer['updated_at'];
    }
}
