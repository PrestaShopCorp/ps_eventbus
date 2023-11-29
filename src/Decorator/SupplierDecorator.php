<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

class SupplierDecorator
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
     * @param array $suppliers
     *
     * @return void
     */
    public function decorateSuppliers(array &$suppliers)
    {
        foreach ($suppliers as &$supplier) {
            $this->castPropertyValues($supplier);
        }
    }

    /**
     * @param array $supplier
     *
     * @return void
     */
    private function castPropertyValues(array &$supplier)
    {
        $supplier['id_supplier'] = (int) $supplier['id_supplier'];
        $supplier['active'] = (bool) $supplier['active'];
        $supplier['id_lang'] = (int) $supplier['id_lang'];
        $supplier['id_shop'] = (int) $supplier['id_shop'];
        $supplier['created_at'] = (new \DateTime($supplier['created_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
        $supplier['updated_at'] = (new \DateTime($supplier['updated_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
    }
}
