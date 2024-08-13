<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class SupplierDecorator
{
    /**
     * @param array<mixed> $suppliers
     *
     * @return void
     */
    public function decorateSuppliers(&$suppliers)
    {
        foreach ($suppliers as &$supplier) {
            $this->castPropertyValues($supplier);
        }
    }

    /**
     * @param array<mixed> $supplier
     *
     * @return void
     */
    private function castPropertyValues(&$supplier)
    {
        $supplier['id_supplier'] = (int) $supplier['id_supplier'];
        $supplier['active'] = (bool) $supplier['active'];
        $supplier['id_lang'] = (int) $supplier['id_lang'];
        $supplier['id_shop'] = (int) $supplier['id_shop'];
        $supplier['created_at'] = (string) $supplier['created_at'];
        $supplier['updated_at'] = (string) $supplier['updated_at'];
    }
}
