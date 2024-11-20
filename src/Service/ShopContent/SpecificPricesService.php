<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ProductRepository;
use PrestaShop\Module\PsEventbus\Repository\SpecificPriceRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SpecificPricesService extends ShopContentAbstractService implements ShopContentServiceInterface
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
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->specificPriceRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCustomPrices($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        $result = $this->specificPriceRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCustomPrices($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_SPECIFIC_PRICES, $result, $deletedContents);
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
            $customPrice['currency'] = isset($customPrice['currency']) ? $customPrice['currency'] : 'ALL';
            $customPrice['country'] = isset($customPrice['country']) ? $customPrice['country'] : 'ALL';
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
     * @param int $idProduct
     * @param int $idProductAttribute
     * @param int $specificPriceId
     * @param bool $usetax
     * @param bool $usereduc
     * @param \Context|null $context
     *
     * @return float|int|void
     *
     * @@throws \PrestaShopException
     */
    private function getPriceStatic(
        $idProduct,
        $idProductAttribute,
        $specificPriceId,
        $usetax = true,
        $usereduc = true,
        $context = null
    ) {
        if (!$context) {
            /** @var \Context $context */
            $context = \Context::getContext();
        }

        \Tools::displayParameterAsDeprecated('divisor');

        if (!\Validate::isBool($usetax) || !\Validate::isUnsignedId($idProduct)) {
            exit(\Tools::displayError());
        }

        // Initializations
        $idGroup = (int) \Group::getCurrent()->id;

        /** @var \Currency $currency */
        $currency = $context->currency;
        $idCurrency = \Validate::isLoadedObject($currency) ? (int) $currency->id : (int) \Configuration::get('PS_CURRENCY_DEFAULT');

        $currentCart = $context->cart;
        $idAddress = null;

        if ($currentCart != null && \Validate::isLoadedObject($currentCart)) {
            $idAddress = $currentCart->{\Configuration::get('PS_TAX_ADDRESS_TYPE')};
        }

        // retrieve address informations
        $address = \Address::initialize($idAddress, true);
        $idCountry = (int) $address->id_country;
        $idState = (int) $address->id_state;
        $zipcode = $address->postcode;

        if (\Tax::excludeTaxeOption()) {
            $usetax = false;
        }

        if (
            $usetax
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
            $idProduct,
            $idProductAttribute,
            $specificPriceId,
            $idCountry,
            $idState,
            $zipcode,
            $idCurrency,
            $idGroup,
            $usetax,
            6,
            false,
            $usereduc,
            $specificPriceOutput,
            true
        );
    }

    /**
     * @param int $idShop
     * @param int $idProduct
     * @param int $idProductAttribute
     * @param int $specificPriceId
     * @param int $idCountry
     * @param int $idState
     * @param string $zipcode
     * @param int $idCurrency
     * @param int $idGroup
     * @param bool $useTax
     * @param int $decimals
     * @param bool $onlyReduc
     * @param bool $useReduc
     * @param array<mixed> $specificPrice
     * @param bool $useGroupReduction
     * @param int $idCustomization
     *
     * @return float|int|void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function priceCalculation(
        $idShop,
        $idProduct,
        $idProductAttribute,
        $specificPriceId,
        $idCountry,
        $idState,
        $zipcode,
        $idCurrency,
        $idGroup,
        $useTax,
        $decimals,
        $onlyReduc,
        $useReduc,
        &$specificPrice,
        $useGroupReduction,
        $idCustomization = 0
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
                $idAddress = $context->cart->{\Configuration::get('PS_TAX_ADDRESS_TYPE')};
                $address = new \Address($idAddress);
            } else {
                $address = new \Address();
            }
        }

        if ($idShop && $context->shop->id != (int) $idShop) {
            $context->shop = new \Shop((int) $idShop);
        }

        if ($idProductAttribute == null) {
            $idProductAttribute = \Product::getDefaultAttribute($idProduct);
        }

        $specificPrice = $this->getSpecificPrice($specificPriceId);

        // fetch price & attribute price
        $cacheId2 = $idProduct . '-' . $idShop . '-' . $specificPriceId;
        if (!isset($pricesLevel2[$cacheId2])) {
            $result = $this->productRepository->getProductPriceAndDeclinations($idProduct);

            if ($result) {
                foreach ($result as $row) {
                    $array_tmp = [
                        'price' => $row['price'],
                        'ecotax' => $row['ecotax'],
                        'attribute_price' => (isset($row['attribute_price']) ? $row['attribute_price'] : null),
                    ];
                    $pricesLevel2[$cacheId2][(int) $row['id_product_attribute']] = $array_tmp;

                    if (isset($row['default_on']) && $row['default_on'] == 1) {
                        $pricesLevel2[$cacheId2][0] = $array_tmp;
                    }
                }
            }
        }

        if (!isset($pricesLevel2[$cacheId2][(int) $idProductAttribute])) {
            return;
        }

        $result = $pricesLevel2[$cacheId2][(int) $idProductAttribute];

        if (!$specificPrice || $specificPrice['price'] < 0) {
            $price = (float) $result['price'];
        } else {
            $price = (float) $specificPrice['price'];
        }
        // convert only if the specific price is in the default currency (id_currency = 0)
        if (!$specificPrice || !($specificPrice['price'] >= 0 && $specificPrice['id_currency'])) {
            $price = \Tools::convertPrice($price, $idCurrency);

            if (isset($specificPrice['price']) && $specificPrice['price'] >= 0) {
                $specificPrice['price'] = $price;
            }
        }

        // Attribute price
        if (is_array($result) && (!$specificPrice || !$specificPrice['id_product_attribute'] || $specificPrice['price'] < 0)) {
            $attributePrice = \Tools::convertPrice($result['attribute_price'] !== null ? (float) $result['attribute_price'] : 0, $idCurrency);
            // If you want the default combination, please use NULL value instead
            if ($idProductAttribute) {
                $price += $attributePrice;
            }
        }

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.0.0', '>=') && (int) $idCustomization) {
            /* @phpstan-ignore-next-line */
            $price += \Tools::convertPrice(\Customization::getCustomizationPrice($idCustomization), $idCurrency);
        }

        // Tax
        $address->id_country = $idCountry;
        $address->id_state = $idState;
        $address->postcode = $zipcode;

        $tax_manager = \TaxManagerFactory::getManager($address, \Product::getIdTaxRulesGroupByIdProduct((int) $idProduct, $context));
        $productTaxCalculator = $tax_manager->getTaxCalculator();

        // Add Tax
        if ($useTax) {
            $price = $productTaxCalculator->addTaxes((float) $price);
        }

        // Eco Tax
        if ($result['ecotax'] || isset($result['attribute_ecotax'])) {
            $ecotax = $result['ecotax'];
            if (isset($result['attribute_ecotax']) && $result['attribute_ecotax'] > 0) {
                $ecotax = $result['attribute_ecotax'];
            }

            if ($idCurrency) {
                $ecotax = \Tools::convertPrice($ecotax, $idCurrency);
            }
            if ($useTax) {
                static $psEcotaxTaxRulesGroupId = null;
                if ($psEcotaxTaxRulesGroupId === null) {
                    $psEcotaxTaxRulesGroupId = (int) \Configuration::get('PS_ECOTAX_TAX_RULES_GROUP_ID');
                }
                // reinit the tax manager for ecotax handling
                $tax_manager = \TaxManagerFactory::getManager(
                    $address,
                    $psEcotaxTaxRulesGroupId
                );
                $ecotaxTaxCalculator = $tax_manager->getTaxCalculator();
                $price += $ecotaxTaxCalculator->addTaxes($ecotax);
            } else {
                $price += $ecotax;
            }
        }

        // Reduction
        $specificPriceReduction = 0;
        if (($onlyReduc || $useReduc) && $specificPrice) {
            if ($specificPrice['reduction_type'] == 'amount') {
                $reductionAmount = $specificPrice['reduction'];

                if (!$specificPrice['id_currency']) {
                    $reductionAmount = \Tools::convertPrice($reductionAmount, $idCurrency);
                }

                $specificPriceReduction = $reductionAmount;

                // Adjust taxes if required

                if (!$useTax && $specificPrice['reduction_tax']) {
                    $specificPriceReduction = $productTaxCalculator->removeTaxes($specificPriceReduction);
                }
                if ($useTax && !$specificPrice['reduction_tax']) {
                    $specificPriceReduction = $productTaxCalculator->addTaxes($specificPriceReduction);
                }
            } else {
                $specificPriceReduction = $price * $specificPrice['reduction'];
            }
        }

        if ($useReduc) {
            $price -= $specificPriceReduction;
        }

        // Group reduction
        if ($useGroupReduction) {
            $reductionFromCategory = \GroupReduction::getValueForProduct($idProduct, $idGroup);
            if ($reductionFromCategory) {
                $groupReduction = $price * (float) $reductionFromCategory;
            } else { // apply group reduction if there is no group reduction for this category
                $groupReduction = (($reduc = \Group::getReductionByIdGroup($idGroup)) != 0) ? ($price * $reduc / 100) : 0;
            }

            $price -= $groupReduction;
        }

        if ($onlyReduc) {
            return \Tools::ps_round($specificPriceReduction, $decimals);
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
