<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

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
