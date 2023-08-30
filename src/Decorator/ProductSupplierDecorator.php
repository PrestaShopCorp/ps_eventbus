<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

class ProductSupplierDecorator
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
     * @param array $productSuppliers
     *
     * @return void
     */
    public function decorateProductSuppliers(array &$productSuppliers)
    {
        foreach ($productSuppliers as &$productSupplier) {
            $this->castProductSupplierPropertyValues($productSupplier);
        }
    }

    /**
     * @param array $productSupplier
     *
     * @return void
     */
    private function castProductSupplierPropertyValues(array &$productSupplier)
    {
        $productSupplier['id_product_supplier'] = (int) $productSupplier['id_product_supplier'];
        $productSupplier['id_product'] = (int) $productSupplier['id_product'];
        $productSupplier['id_product_attribute'] = (int) $productSupplier['id_product_attribute'];
        $productSupplier['id_supplier'] = (int) $productSupplier['id_supplier'];
        $productSupplier['product_supplier_price_te'] = (float) $productSupplier['product_supplier_price_te'];
        $productSupplier['id_currency'] = (int) $productSupplier['id_currency'];
        $productSupplier['created_at'] = (new \DateTime($productSupplier['created_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
        $productSupplier['updated_at'] = (new \DateTime($productSupplier['updated_at'], new \DateTimeZone($this->timezone)))->format('Y-m-d\TH:i:sO');
    }
}
