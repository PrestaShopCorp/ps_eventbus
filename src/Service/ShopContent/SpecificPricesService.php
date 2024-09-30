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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ProductRepository;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\SpecificPriceRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SpecificPricesService implements ShopContentServiceInterface
{
    /** @var SpecificPriceRepository */
    private $specificPriceRepository;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(
        SpecificPriceRepository $specificPriceRepository,
        ProductRepository $productRepository
    ) {
        $this->specificPriceRepository = $specificPriceRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->specificPriceRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCustomPrices($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_specific_price'],
                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->specificPriceRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCustomPrices($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_specific_price'],
                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->specificPriceRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $customPrices
     *
     * @return void
     */
    private function castCustomPrices(&$customPrices)
    {
        foreach ($customPrices as &$customPrice) {
            $context = \Context::getContext();

            if ($context == null) {
                throw new \PrestaShopException('Context not found');
            }

            if ($context->shop === null) {
                throw new \PrestaShopException('No shop context');
            }

            $context->country = new \Country($customPrice['id_country']);
            $context->currency = new \Currency($customPrice['id_currency']);

            $customPrice['price_tax_included'] = $this->getPriceStatic(
                $customPrice['id_product'],
                $customPrice['id_product_attribute'],
                $customPrice['id_specific_price'],
                true,
                false,
                $context
            );

            $customPrice['price_tax_excluded'] = $this->getPriceStatic(
                $customPrice['id_product'],
                $customPrice['id_product_attribute'],
                $customPrice['id_specific_price'],
                false,
                false,
                $context
            );
            $customPrice['sale_price_tax_incl'] = $this->getPriceStatic(
                $customPrice['id_product'],
                $customPrice['id_product_attribute'],
                $customPrice['id_specific_price'],
                true,
                true,
                $context
            );
            $customPrice['sale_price_tax_excl'] = $this->getPriceStatic(
                $customPrice['id_product'],
                $customPrice['id_product_attribute'],
                $customPrice['id_specific_price'],
                false,
                true,
                $context
            );

            if ($customPrice['id_shop']) {
                $customPrice['id_shop'] = $context->shop->id;
            }

            $customPrice['id_specific_price'] = (int) $customPrice['id_specific_price'];
            $customPrice['id_product'] = (int) $customPrice['id_product'];
            $customPrice['id_shop'] = (int) $customPrice['id_shop'];
            $customPrice['id_group'] = (int) $customPrice['id_group'];
            $customPrice['id_shop_group'] = (int) $customPrice['id_shop_group'];
            $customPrice['id_product_attribute'] = (int) $customPrice['id_product_attribute'];
            $customPrice['price'] = (float) $customPrice['price'];
            $customPrice['from_quantity'] = (int) $customPrice['from_quantity'];
            $customPrice['reduction'] = (float) $customPrice['reduction'];
            $customPrice['reduction_tax'] = (int) $customPrice['reduction_tax'];
            $customPrice['id_currency'] = (int) $customPrice['id_currency'];
            $customPrice['id_country'] = (int) $customPrice['id_country'];
            $customPrice['id_customer'] = (int) $customPrice['id_customer'];
            $customPrice['currency'] = $customPrice['currency'] ?: 'ALL';
            $customPrice['country'] = $customPrice['country'] ?: 'ALL';
            $customPrice['price_tax_included'] = (float) $customPrice['price_tax_included'];
            $customPrice['price_tax_excluded'] = (float) $customPrice['price_tax_excluded'];
            $customPrice['sale_price_tax_incl'] = (float) $customPrice['sale_price_tax_incl'];
            $customPrice['sale_price_tax_excl'] = (float) $customPrice['sale_price_tax_excl'];

            if ($customPrice['reduction_type'] === 'percentage') {
                $customPrice['discount_percentage'] = $customPrice['reduction'] * 100;
                $customPrice['discount_value_tax_incl'] = 0.0;
                $customPrice['discount_value_tax_excl'] = 0.0;
            } else {
                $customPrice['discount_percentage'] = 0;
                $customPrice['discount_value_tax_incl'] = $customPrice['price_tax_included'] - $customPrice['sale_price_tax_incl'];
                $customPrice['discount_value_tax_excl'] = $customPrice['price_tax_excluded'] - $customPrice['sale_price_tax_excl'];
            }
        }
    }

    /**
     * @param int $id_product
     * @param int $id_product_attribute
     * @param int $specificPriceId
     * @param bool $usetax
     * @param bool $usereduc
     * @param \Context|null $context
     * @param int $decimals
     * @param null $divisor
     * @param bool $only_reduc
     * @param null $id_customer
     * @param null $id_cart
     * @param null $id_address
     * @param null $specific_price_output
     * @param bool $use_group_reduction
     *
     * @return float|int|void
     *
     * @@throws \PrestaShopException
     */
    private function getPriceStatic(
        $id_product,
        $id_product_attribute,
        $specificPriceId,
        $usetax = true,
        $usereduc = true,
        $context = null,
        $decimals = 6,
        $divisor = null,
        $only_reduc = false,
        $id_customer = null,
        $id_cart = null,
        $id_address = null,
        &$specific_price_output = null,
        $use_group_reduction = true
    ) {
        if (!$context) {
            /** @var \Context $context */
            $context = \Context::getContext();
        }

        \Tools::displayParameterAsDeprecated('divisor');

        if (!\Validate::isBool($usetax) || !\Validate::isUnsignedId($id_product)) {
            exit(\Tools::displayError());
        }

        // Initializations
        $id_group = (int) \Group::getCurrent()->id;

        /** @var \Currency $currency */
        $currency = $context->currency;
        $id_currency = \Validate::isLoadedObject($currency) ? (int) $currency->id : (int) \Configuration::get('PS_CURRENCY_DEFAULT');

        $current_cart = $context->cart;
        if ($current_cart != null && \Validate::isLoadedObject($current_cart)) {
            $id_address = $current_cart->{\Configuration::get('PS_TAX_ADDRESS_TYPE')};
        }

        // retrieve address informations
        $address = \Address::initialize($id_address, true);
        $id_country = (int) $address->id_country;
        $id_state = (int) $address->id_state;
        $zipcode = $address->postcode;

        if (\Tax::excludeTaxeOption()) {
            $usetax = false;
        }

        if (
            $usetax != false
            && !empty($address->vat_number)
            && $address->id_country != \Configuration::get('VATNUMBER_COUNTRY')
            && \Configuration::get('VATNUMBER_MANAGEMENT')
        ) {
            $usetax = false;
        }

        if ($context->shop == null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $context->shop->id;

        return $this->priceCalculation(
            $shopId,
            $id_product,
            $id_product_attribute,
            $specificPriceId,
            $id_country,
            $id_state,
            $zipcode,
            $id_currency,
            $id_group,
            $usetax,
            $decimals,
            $only_reduc,
            $usereduc,
            $specific_price_output,
            $use_group_reduction
        );
    }

    /**
     * @param int $id_shop
     * @param int $id_product
     * @param int $id_product_attribute
     * @param int $specificPriceId
     * @param int $id_country
     * @param int $id_state
     * @param string $zipcode
     * @param int $id_currency
     * @param int $id_group
     * @param bool $use_tax
     * @param int $decimals
     * @param bool $only_reduc
     * @param bool $use_reduc
     * @param null $specific_price
     * @param bool $use_group_reduction
     * @param int $id_customization
     *
     * @return float|int|void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function priceCalculation(
        $id_shop,
        $id_product,
        $id_product_attribute,
        $specificPriceId,
        $id_country,
        $id_state,
        $zipcode,
        $id_currency,
        $id_group,
        $use_tax,
        $decimals,
        $only_reduc,
        $use_reduc,
        &$specific_price,
        $use_group_reduction,
        $id_customization = 0
    ) {
        static $address = null;
        static $context = null;

        /** @var array<mixed> */
        static $pricesLevel2;

        if ($context == null) {
            /** @var \Context $context */
            $context = \Context::getContext();
            $context = $context->cloneContext();
        }

        if ($address === null) {
            if (is_object($context->cart) && $context->cart->{\Configuration::get('PS_TAX_ADDRESS_TYPE')} != null) {
                $id_address = $context->cart->{\Configuration::get('PS_TAX_ADDRESS_TYPE')};
                $address = new \Address($id_address);
            } else {
                $address = new \Address();
            }
        }

        if ($id_shop !== null && $context->shop->id != (int) $id_shop) {
            $context->shop = new \Shop((int) $id_shop);
        }

        if ($id_product_attribute == null) {
            $id_product_attribute = \Product::getDefaultAttribute($id_product);
        }

        // reference parameter is filled before any returns
        /** @var array<mixed> $specific_price */
        $specific_price = $this->getSpecificPrice($specificPriceId);

        // fetch price & attribute price
        $cache_id_2 = $id_product . '-' . $id_shop . '-' . $specificPriceId;
        if (!isset($pricesLevel2[$cache_id_2])) {
            $result = $this->productRepository->getProductPriceAndDeclinations($id_product);

            if (is_array($result) && count($result)) {
                foreach ($result as $row) {
                    $array_tmp = [
                        'price' => $row['price'],
                        'ecotax' => $row['ecotax'],
                        'attribute_price' => (isset($row['attribute_price']) ? $row['attribute_price'] : null),
                    ];
                    $pricesLevel2[$cache_id_2][(int) $row['id_product_attribute']] = $array_tmp;

                    if (isset($row['default_on']) && $row['default_on'] == 1) {
                        $pricesLevel2[$cache_id_2][0] = $array_tmp;
                    }
                }
            }
        }

        if (!isset($pricesLevel2[$cache_id_2][(int) $id_product_attribute])) {
            return;
        }

        $result = $pricesLevel2[$cache_id_2][(int) $id_product_attribute];

        if (!$specific_price || $specific_price['price'] < 0) {
            $price = (float) $result['price'];
        } else {
            $price = (float) $specific_price['price'];
        }
        // convert only if the specific price is in the default currency (id_currency = 0)
        if (!$specific_price || !($specific_price['price'] >= 0 && $specific_price['id_currency'])) {
            $price = \Tools::convertPrice($price, $id_currency);

            if (isset($specific_price['price']) && $specific_price['price'] >= 0) {
                $specific_price['price'] = $price;
            }
        }

        // Attribute price
        if (is_array($result) && (!$specific_price || !$specific_price['id_product_attribute'] || $specific_price['price'] < 0)) {
            $attribute_price = \Tools::convertPrice($result['attribute_price'] !== null ? (float) $result['attribute_price'] : 0, $id_currency);
            // If you want the default combination, please use NULL value instead
            if ($id_product_attribute !== false) {
                $price += $attribute_price;
            }
        }

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            // Customization price
            if ((int) $id_customization) {
                /* @phpstan-ignore-next-line */
                $price += \Tools::convertPrice(\Customization::getCustomizationPrice($id_customization), $id_currency);
            }
        }

        // Tax
        $address->id_country = $id_country;
        $address->id_state = $id_state;
        $address->postcode = $zipcode;

        $tax_manager = \TaxManagerFactory::getManager($address, \Product::getIdTaxRulesGroupByIdProduct((int) $id_product, $context));
        $product_tax_calculator = $tax_manager->getTaxCalculator();

        // Add Tax
        if ($use_tax) {
            $price = $product_tax_calculator->addTaxes((float) $price);
        }

        // Eco Tax
        if ($result['ecotax'] || isset($result['attribute_ecotax'])) {
            $ecotax = $result['ecotax'];
            if (isset($result['attribute_ecotax']) && $result['attribute_ecotax'] > 0) {
                $ecotax = $result['attribute_ecotax'];
            }

            if ($id_currency) {
                $ecotax = \Tools::convertPrice($ecotax, $id_currency);
            }
            if ($use_tax) {
                static $psEcotaxTaxRulesGroupId = null;
                if ($psEcotaxTaxRulesGroupId === null) {
                    $psEcotaxTaxRulesGroupId = (int) \Configuration::get('PS_ECOTAX_TAX_RULES_GROUP_ID');
                }
                // reinit the tax manager for ecotax handling
                $tax_manager = \TaxManagerFactory::getManager(
                    $address,
                    $psEcotaxTaxRulesGroupId
                );
                $ecotax_tax_calculator = $tax_manager->getTaxCalculator();
                $price += $ecotax_tax_calculator->addTaxes($ecotax);
            } else {
                $price += $ecotax;
            }
        }

        // Reduction
        $specific_price_reduction = 0;
        if (($only_reduc || $use_reduc) && $specific_price) {
            if ($specific_price['reduction_type'] == 'amount') {
                $reduction_amount = $specific_price['reduction'];

                if (!$specific_price['id_currency']) {
                    $reduction_amount = \Tools::convertPrice($reduction_amount, $id_currency);
                }

                $specific_price_reduction = $reduction_amount;

                // Adjust taxes if required

                if (!$use_tax && $specific_price['reduction_tax']) {
                    $specific_price_reduction = $product_tax_calculator->removeTaxes($specific_price_reduction);
                }
                if ($use_tax && !$specific_price['reduction_tax']) {
                    $specific_price_reduction = $product_tax_calculator->addTaxes($specific_price_reduction);
                }
            } else {
                $specific_price_reduction = $price * $specific_price['reduction'];
            }
        }

        if ($use_reduc) {
            $price -= $specific_price_reduction;
        }

        // Group reduction
        if ($use_group_reduction) {
            $reduction_from_category = \GroupReduction::getValueForProduct($id_product, $id_group);
            if ($reduction_from_category !== false) {
                $group_reduction = $price * (float) $reduction_from_category;
            } else { // apply group reduction if there is no group reduction for this category
                $group_reduction = (($reduc = \Group::getReductionByIdGroup($id_group)) != 0) ? ($price * $reduc / 100) : 0;
            }

            $price -= $group_reduction;
        }

        if ($only_reduc) {
            return \Tools::ps_round($specific_price_reduction, $decimals);
        }

        $price = \Tools::ps_round((float) $price, $decimals);

        if ($price < 0) {
            $price = 0;
        }

        return $price;
    }

    /**
     * Returns the specificPrice information related to a given productId and context.
     *
     * @param int $specificPriceId
     *
     * @return array<mixed>
     */
    private function getSpecificPrice($specificPriceId)
    {
        if (!\SpecificPrice::isFeatureActive()) {
            return [];
        }

        return $this->specificPriceRepository->getSpecificPriceById($specificPriceId)[0];
    }
}
