<?php

use PrestaShop\Module\PsEventbus\Decorator\ProductDecorator;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\BundleRepository;
use PrestaShop\Module\PsEventbus\Repository\CategoryRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\ProductRepository;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("decorator")
 * @Stories("product decorator")
 */
class ProductDecoratorTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @Stories("product decorator")
     * @Title("testDecorateProducts")
     */
    public function testDecorateProducts()
    {
        $products = [
            [
                'id_product' => '1',
                'id_attribute' => '3',
                'name' => 'Hummingbird printed t-shirt',
                'description' => '<p>SOME HTML</p>',
                'description_short' => '<p>SOME HTML</p>',
                'link_rewrite' => 'hummingbird-printed-t-shirt',
                'iso_code' => 'lt',
                'default_category' => 'Men',
                'id_category_default' => '4',
                'reference' => 'demo_1',
                'upc' => '',
                'ean' => '',
                'isbn' => '',
                'condition' => 'new',
                'visibility' => 'both',
                'active' => true,
                'quantity' => '300',
                'manufacturer' => 'Studio Design',
                'weight' => '10.0',
                'price_tax_excl' => '23.9',
                'created_at' => '2020-08-19 08:29:12',
                'updated_at' => '2020-09-22 10:02:45',
                'attributes' => 'Dydis:M;Spalva:Balta',
                'features' => 'Savybė:Trumpos rankovės;Sudėtis:Medvilnė',
                'images' => '1:1;2:0',
                'attribute_images' => '1;2;3',
                'is_default_attribute' => '1',
                'available_for_order' => '1',
                'available_date' => '0000-00-00',
                'is_bundle' => '0',
                'is_virtual' => '1',
            ],
            [
                'id_product' => '2',
                'id_attribute' => '0',
                'name' => 'Hummingbird printed t-shirt',
                'description' => '<p>SOME HTML</p>',
                'description_short' => '<p>SOME HTML</p>',
                'link_rewrite' => 'hummingbird-printed-t-shirt',
                'iso_code' => 'lt',
                'default_category' => 'Men',
                'id_category_default' => '4',
                'reference' => 'demo_1',
                'upc' => '',
                'ean' => '',
                'isbn' => '',
                'condition' => 'new',
                'visibility' => 'both',
                'active' => true,
                'quantity' => '300',
                'manufacturer' => 'Studio Design',
                'weight' => '10.0',
                'price_tax_excl' => '23.9',
                'created_at' => '2020-08-19 08:29:12',
                'updated_at' => '2020-09-22 10:02:45',
                'attributes' => 'Dydis:M;Spalva:Balta',
                'features' => 'Savybė:Trumpos rankovės;Sudėtis:Medvilnė',
                'images' => '1:1;2:0',
                'attribute_images' => '1',
                'is_default_attribute' => '1',
                'available_for_order' => '1',
                'available_date' => '0000-00-00',
                'is_bundle' => '0',
                'is_virtual' => '1',
            ],
            [
                'id_product' => '2',
                'id_attribute' => '0',
                'name' => 'Hummingbird printed t-shirt',
                'description' => '<p>SOME HTML</p>',
                'description_short' => '<p>SOME HTML</p>',
                'link_rewrite' => 'hummingbird-printed-t-shirt',
                'iso_code' => 'lt',
                'default_category' => 'Men',
                'id_category_default' => '4',
                'reference' => 'demo_1',
                'upc' => '',
                'ean' => '',
                'isbn' => '',
                'condition' => 'new',
                'visibility' => 'both',
                'active' => true,
                'quantity' => '300',
                'manufacturer' => 'Studio Design',
                'weight' => '10.0',
                'price_tax_excl' => '23.9',
                'created_at' => '2020-08-19 08:29:12',
                'updated_at' => '2020-09-22 10:02:45',
                'attributes' => 'Dydis:M;Spalva:Balta',
                'features' => 'Savybė:Trumpos rankovės;Sudėtis:Medvilnė',
                'images' => '1:1;2:0',
                'attribute_images' => '1',
                'is_default_attribute' => '1',
                'available_for_order' => '1',
                'available_date' => '0000-00-00',
                'is_bundle' => '0',
                'is_virtual' => '1',
            ],
        ];

        $categories = [
            'category_path' => 'Root > Home > Clothes > Men',
            'category_id_path' => '1 > 2 > 3 > 4',
        ];

        $contextMock = $this->createMock(Context::class);
        $linkMock = $this->createMock(Link::class);
        $linkMock->method('getProductLink')->willReturn('https://test.link/1-0-product.html');
        $linkMock->method('getImageLink')->willReturn('https://test.link/1-0-product.jpg');

        $shopMock = $this->createMock(Shop::class);
        $shopMock->id = 1;

        $contextMock->link = $linkMock;
        $contextMock->shop = $shopMock;

        $languageRepository = $this->createMock(LanguageRepository::class);
        $languageRepository->method('getLanguageIdByIsoCode')->willReturn(1);
        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->method('getProductImages')->willReturn([]);
        $productRepository->method('getAttributeImages')->willReturn([]);
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->method('getCategoryPaths')->willReturn($categories);
        $bundleRepository = $this->createMock(BundleRepository::class);

        $arrayFormatter = new ArrayFormatter();

        $productDecorator = new ProductDecorator($contextMock, $languageRepository, $productRepository, $categoryRepository, $arrayFormatter, $bundleRepository);
        $productDecorator->decorateProducts($products, 'en', 1);

        $this->assertInternalType('int', $products[0]['id_product']);
        $this->assertInternalType('int', $products[0]['id_category_default']);
        $this->assertInternalType('float', $products[0]['price_tax_excl']);
        $this->assertInternalType('float', $products[0]['price_tax_incl']);
    }
}
