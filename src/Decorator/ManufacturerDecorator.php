<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

class ManufacturerDecorator
{
    /**
     * @var string
     */
    private $timezone;

    public function __construct(
        ConfigurationRepository $configurationRepository
    ) {
        $this->timezone = (string) $configurationRepository->get('PS_TIMEZONE');
    }

    /**
     * @param array $manufacturers
     *
     * @return void
     */
    public function decorateManufacturers(array &$manufacturers)
    {
        foreach ($manufacturers as &$manufacturer) {
            $this->castPropertyValues($manufacturer);
        }
    }

    /**
     * @param array $manufacturer
     *
     * @return void
     */
    private function castPropertyValues(array &$manufacturer)
    {
        $manufacturer['id_manufacturer'] = (int) $manufacturer['id_manufacturer'];
        $manufacturer['active'] = (bool) $manufacturer['active'];
        $manufacturer['id_lang'] = (int) $manufacturer['id_lang'];
        $manufacturer['id_shop'] = (int) $manufacturer['id_shop'];
        $manufacturer['created_at'] = (new \DateTime($manufacturer['created_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
        $manufacturer['updated_at'] = (new \DateTime($manufacturer['updated_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
    }
}
