<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Service\SpecificPriceService;

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

    public function decorateSpecificPrices(array &$specificPrices): void
    {
        foreach ($specificPrices as &$specificPrice) {
            $this->addTotalPrice($specificPrice);
            $this->setShopId($specificPrice);
            $this->castPropertyValues($specificPrice);
        }
    }

    private function addTotalPrice(array &$specificPrice): void
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

    private function castPropertyValues(array &$specificPrice): void
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

    private function setShopId(array &$specificPrice): void
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        if ($specificPrice['id_shop']) {
            $specificPrice['id_shop'] = $this->context->shop->id;
        }
    }
}
