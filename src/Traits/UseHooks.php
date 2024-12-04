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

namespace PrestaShop\Module\PsEventbus\Traits;

use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCarrierHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCartHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCartRuleHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCategoryHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCombinationHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCommonHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCountryHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCurrencyHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCustomerHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseEmployeeHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseImageHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseImageTypesHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseLanguageHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseManufacturerHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseOrderHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseProductHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseShippingPreferenceHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseSpecificPriceHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseStateHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseStockHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseStoreHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseSupplierHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseTaxeRuleGroupHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseTaxHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseWishlistHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseZoneHooks;

if (!defined('_PS_VERSION_')) {
    exit;
}

trait UseHooks
{
    use UseCarrierHooks;
    use UseCartHooks;
    use UseCartRuleHooks;
    use UseCategoryHooks;
    use UseCombinationHooks;
    use UseCommonHooks;
    use UseCountryHooks;
    use UseCurrencyHooks;
    use UseCustomerHooks;
    use UseEmployeeHooks;
    use UseImageHooks;
    use UseImageTypesHooks;
    use UseLanguageHooks;
    use UseManufacturerHooks;
    use UseOrderHooks;
    use UseProductHooks;
    use UseShippingPreferenceHooks;
    use UseSpecificPriceHooks;
    use UseStateHooks;
    use UseStockHooks;
    use UseStoreHooks;
    use UseSupplierHooks;
    use UseTaxHooks;
    use UseTaxeRuleGroupHooks;
    use UseWishlistHooks;
    use UseZoneHooks;

    /**
     * @return array<string>
     */
    public function getHooks()
    {
        // Retourne la liste des hooks a register
        return [
            'actionObjectCarrierAddAfter',
            'actionObjectCarrierDeleteAfter',
            'actionObjectCarrierUpdateAfter',

            'actionObjectCartAddAfter',
            'actionObjectCartUpdateAfter',

            'actionObjectCartRuleAddAfter',
            'actionObjectCartRuleDeleteAfter',
            'actionObjectCartRuleUpdateAfter',

            'actionObjectCategoryAddAfter',
            'actionObjectCategoryDeleteAfter',
            'actionObjectCategoryUpdateAfter',

            'actionObjectCombinationDeleteAfter',

            'actionObjectCountryAddAfter',
            'actionObjectCountryDeleteAfter',
            'actionObjectCountryUpdateAfter',

            'actionObjectCurrencyAddAfter',
            'actionObjectCurrencyUpdateAfter',

            'actionObjectCustomerAddAfter',
            'actionObjectCustomerDeleteAfter',
            'actionObjectCustomerUpdateAfter',

            'actionObjectImageAddAfter',
            'actionObjectImageDeleteAfter',
            'actionObjectImageUpdateAfter',

            'actionObjectLanguageAddAfter',
            'actionObjectLanguageDeleteAfter',
            'actionObjectLanguageUpdateAfter',

            'actionObjectManufacturerAddAfter',
            'actionObjectManufacturerDeleteAfter',
            'actionObjectManufacturerUpdateAfter',

            'actionObjectOrderAddAfter',
            'actionObjectOrderUpdateAfter',

            'actionObjectProductAddAfter',
            'actionObjectProductDeleteAfter',
            'actionObjectProductUpdateAfter',

            'actionObjectSpecificPriceAddAfter',
            'actionObjectSpecificPriceDeleteAfter',
            'actionObjectSpecificPriceUpdateAfter',

            'actionObjectStateAddAfter',
            'actionObjectStateDeleteAfter',
            'actionObjectStateUpdateAfter',

            'actionObjectStockAddAfter',
            'actionObjectStockUpdateAfter',

            'actionObjectStoreAddAfter',
            'actionObjectStoreDeleteAfter',
            'actionObjectStoreUpdateAfter',

            'actionObjectSupplierAddAfter',
            'actionObjectSupplierDeleteAfter',
            'actionObjectSupplierUpdateAfter',

            'actionObjectTaxAddAfter',
            'actionObjectTaxDeleteAfter',
            'actionObjectTaxRulesGroupAddAfter',
            'actionObjectTaxRulesGroupDeleteAfter',
            'actionObjectTaxRulesGroupUpdateAfter',
            'actionObjectTaxUpdateAfter',

            'actionObjectWishlistAddAfter',
            'actionObjectWishlistDeleteAfter',
            'actionObjectWishlistUpdateAfter',

            'actionObjectZoneAddAfter',
            'actionObjectZoneDeleteAfter',
            'actionObjectZoneUpdateAfter',

            'actionShippingPreferencesPageSave',

            'actionObjectEmployeeAddAfter',
            'actionObjectEmployeeDeleteAfter',
            'actionObjectEmployeeUpdateAfter',

            'actionDispatcherBefore',
        ];
    }
}
