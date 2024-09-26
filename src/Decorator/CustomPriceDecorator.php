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

use PrestaShop\Module\PsEventbus\Service\SpecificPriceService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CustomPriceDecorator
{
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var SpecificPriceService
     */
    private $priceService;

    public function __construct(
        \Context $context,
        SpecificPriceService $priceService
    ) {
        $this->context = $context;
        $this->priceService = $priceService;
    }

    /**
     * @param array<mixed> $specificPrices
     *
     * @return void
     */
    public function decorateSpecificPrices(&$specificPrices)
    {
        foreach ($specificPrices as &$specificPrice) {
            $this->addTotalPrice($specificPrice);
            $this->setShopId($specificPrice);
            $this->castPropertyValues($specificPrice);
        }
    }

    /**
     * @param array<mixed> $specificPrice
     *
     * @return void
     */
    private function addTotalPrice(&$specificPrice)
    {
        $this->context->country = new \Country($specificPrice['id_country']);
        $this->context->currency = new \Currency($specificPrice['id_currency']);

        $specificPrice['price_tax_included'] = $this->priceService->getSpecificProductPrice(
            $specificPrice['id_product'],
            $specificPrice['id_product_attribute'],
            $specificPrice['id_specific_price'],
            true,
            false,
            $this->context
        );

        $specificPrice['price_tax_excluded'] = $this->priceService->getSpecificProductPrice(
            $specificPrice['id_product'],
            $specificPrice['id_product_attribute'],
            $specificPrice['id_specific_price'],
            false,
            false,
            $this->context
        );
        $specificPrice['sale_price_tax_incl'] = $this->priceService->getSpecificProductPrice(
            $specificPrice['id_product'],
            $specificPrice['id_product_attribute'],
            $specificPrice['id_specific_price'],
            true,
            true,
            $this->context
        );
        $specificPrice['sale_price_tax_excl'] = $this->priceService->getSpecificProductPrice(
            $specificPrice['id_product'],
            $specificPrice['id_product_attribute'],
            $specificPrice['id_specific_price'],
            false,
            true,
            $this->context
        );
    }

    /**
     * @param array<mixed> $specificPrice
     *
     * @return void
     */
    private function castPropertyValues(&$specificPrice)
    {
        $specificPrice['id_specific_price'] = (int) $specificPrice['id_specific_price'];
        $specificPrice['id_product'] = (int) $specificPrice['id_product'];
        $specificPrice['id_shop'] = (int) $specificPrice['id_shop'];
        $specificPrice['id_group'] = (int) $specificPrice['id_group'];
        $specificPrice['id_shop_group'] = (int) $specificPrice['id_shop_group'];
        $specificPrice['id_product_attribute'] = (int) $specificPrice['id_product_attribute'];
        $specificPrice['price'] = (float) $specificPrice['price'];
        $specificPrice['from_quantity'] = (int) $specificPrice['from_quantity'];
        $specificPrice['reduction'] = (float) $specificPrice['reduction'];
        $specificPrice['reduction_tax'] = (int) $specificPrice['reduction_tax'];
        $specificPrice['id_currency'] = (int) $specificPrice['id_currency'];
        $specificPrice['id_country'] = (int) $specificPrice['id_country'];
        $specificPrice['id_customer'] = (int) $specificPrice['id_customer'];
        $specificPrice['currency'] = $specificPrice['currency'] ?: 'ALL';
        $specificPrice['country'] = $specificPrice['country'] ?: 'ALL';
        $specificPrice['price_tax_included'] = (float) $specificPrice['price_tax_included'];
        $specificPrice['price_tax_excluded'] = (float) $specificPrice['price_tax_excluded'];
        $specificPrice['sale_price_tax_incl'] = (float) $specificPrice['sale_price_tax_incl'];
        $specificPrice['sale_price_tax_excl'] = (float) $specificPrice['sale_price_tax_excl'];

        if ($specificPrice['reduction_type'] === 'percentage') {
            $specificPrice['discount_percentage'] = $specificPrice['reduction'] * 100;
            $specificPrice['discount_value_tax_incl'] = 0.0;
            $specificPrice['discount_value_tax_excl'] = 0.0;
        } else {
            $specificPrice['discount_percentage'] = 0;
            $specificPrice['discount_value_tax_incl'] = $specificPrice['price_tax_included'] - $specificPrice['sale_price_tax_incl'];
            $specificPrice['discount_value_tax_excl'] = $specificPrice['price_tax_excluded'] - $specificPrice['sale_price_tax_excl'];
        }
    }

    /**
     * @param array<mixed> $specificPrice
     *
     * @return void
     */
    private function setShopId(&$specificPrice)
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        if ($specificPrice['id_shop']) {
            $specificPrice['id_shop'] = $this->context->shop->id;
        }
    }
}
