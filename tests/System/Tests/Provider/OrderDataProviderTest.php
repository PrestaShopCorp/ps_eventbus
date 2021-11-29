<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests\Provider;

use PrestaShop\Module\PsEventbus\Provider\OrderDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;

class OrderDataProviderTest extends BaseTestCase
{
    /**
     * @dataProvider getDataProviderInfo
     */
    public function testDataProviders(PaginatedApiDataProviderInterface $dataProvider)
    {
        $formattedData = $dataProvider->getFormattedData(0, 50, 'en');
        foreach ($formattedData as $data) {
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('collection', $data);
            $this->assertArrayHasKey('properties', $data);
            $properties = $data['properties'];

            if ($data['collection'] == 'orders') {
                $this->assertArrayHasKey('id_order', $properties);
                $this->assertArrayHasKey('reference', $properties);
                $this->assertArrayHasKey('id_customer', $properties);
                $this->assertArrayHasKey('id_cart', $properties);
                $this->assertArrayHasKey('current_state', $properties);
                $this->assertArrayHasKey('conversion_rate', $properties);
                $this->assertArrayHasKey('total_paid_tax_excl', $properties);
                $this->assertArrayHasKey('total_paid_tax_incl', $properties);
                $this->assertArrayHasKey('new_customer', $properties);
                $this->assertArrayHasKey('currency', $properties);
                $this->assertArrayHasKey('refund', $properties);
                $this->assertArrayHasKey('refund_tax_excl', $properties);
                $this->assertArrayHasKey('payment_module', $properties);
                $this->assertArrayHasKey('payment_mode', $properties);
                $this->assertArrayHasKey('total_paid_real', $properties);
                $this->assertArrayHasKey('shipping_cost', $properties);
                $this->assertArrayHasKey('created_at', $properties);
                $this->assertArrayHasKey('updated_at', $properties);
                $this->assertArrayHasKey('is_paid', $properties);
                $this->assertArrayHasKey('total_paid_tax', $properties);
                $this->assertArrayHasKey('invoice_country_code', $properties);
                $this->assertArrayHasKey('delivery_country_code', $properties);
                $this->assertArrayHasKey('id_carrier', $properties);
            } elseif ($data['collection'] == 'order_details') {
                $this->assertArrayHasKey('id_order_detail', $properties);
                $this->assertArrayHasKey('id_order', $properties);
                $this->assertArrayHasKey('product_id', $properties);
                $this->assertArrayHasKey('product_attribute_id', $properties);
                $this->assertArrayHasKey('product_quantity', $properties);
                $this->assertArrayHasKey('unit_price_tax_incl', $properties);
                $this->assertArrayHasKey('unit_price_tax_excl', $properties);
                $this->assertArrayHasKey('refund', $properties);
                $this->assertArrayHasKey('refund_tax_excl', $properties);
                $this->assertArrayHasKey('currency', $properties);
                $this->assertArrayHasKey('category', $properties);
                $this->assertArrayHasKey('iso_code', $properties);
                $this->assertArrayHasKey('conversion_rate', $properties);
                $this->assertArrayHasKey('created_at', $properties);
                $this->assertArrayHasKey('updated_at', $properties);
                $this->assertArrayHasKey('unique_product_id', $properties);
            }
        }
    }

    public function getDataProviderInfo()
    {
        return [
            [
                'provider' => $this->container->getService(OrderDataProvider::class),
            ],
        ];
    }
}
