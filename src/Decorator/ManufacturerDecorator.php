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

if (!defined('_PS_VERSION_')) {
    exit;
}

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
