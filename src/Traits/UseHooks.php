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
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCurrencyHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseCustomerHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseEmployeeHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseImageHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseImageTypeHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseLanguageHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseManufacturerHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseOrderCarrierHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseOrderCartRuleHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseOrderDetailHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseOrderHistoryHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseOrderHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseProductHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseSpecificPriceHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseStockHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseStockMvtHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseStoreHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseSupplierHooks;
use PrestaShop\Module\PsEventbus\Traits\Hooks\UseWishlistHooks;

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
    use UseCurrencyHooks;
    use UseCustomerHooks;
    use UseEmployeeHooks;
    use UseImageHooks;
    use UseImageTypeHooks;
    use UseLanguageHooks;
    use UseManufacturerHooks;
    use UseOrderCarrierHooks;
    use UseOrderCartRuleHooks;
    use UseOrderDetailHooks;
    use UseOrderHistoryHooks;
    use UseOrderHooks;
    use UseProductHooks;
    use UseSpecificPriceHooks;
    use UseStockHooks;
    use UseStockMvtHooks;
    use UseStoreHooks;
    use UseSupplierHooks;
    use UseWishlistHooks;

    /**
     * @return array<string>
     */
    public function getHooks()
    {
        // Retourne la liste des hooks a register
        return [
            'actionObjectCarrierAddAfter',
            'actionObjectCarrierUpdateAfter',
            'actionObjectCarrierDeleteAfter',

            'actionObjectCartAddAfter',
            'actionObjectCartUpdateAfter',

            'actionObjectCartRuleAddAfter',
            'actionObjectCartRuleUpdateAfter',
            'actionObjectCartRuleDeleteAfter',

            'actionObjectCategoryAddAfter',
            'actionObjectCategoryUpdateAfter',
            'actionObjectCategoryDeleteAfter',

            'actionObjectCombinationAddAfter',
            'actionObjectCombinationUpdateAfter',
            'actionObjectCombinationDeleteAfter',

            'actionObjectCurrencyAddAfter',
            'actionObjectCurrencyUpdateAfter',
            'actionObjectCurrencyDeleteAfter',

            'actionObjectCustomerAddAfter',
            'actionObjectCustomerUpdateAfter',
            'actionObjectCustomerDeleteAfter',

            'actionObjectEmployeeAddAfter',
            'actionObjectEmployeeUpdateAfter',
            'actionObjectEmployeeDeleteAfter',

            'actionObjectImageAddAfter',
            'actionObjectImageUpdateAfter',
            'actionObjectImageDeleteAfter',

            'actionObjectImageTypeAddAfter',
            'actionObjectImageTypeUpdateAfter',
            'actionObjectImageTypeDeleteAfter',

            'actionObjectLanguageAddAfter',
            'actionObjectLanguageUpdateAfter',
            'actionObjectLanguageDeleteAfter',

            'actionObjectManufacturerAddAfter',
            'actionObjectManufacturerUpdateAfter',
            'actionObjectManufacturerDeleteAfter',

            'actionObjectOrderCarrierAddAfter',
            'actionObjectOrderCarrierUpdateAfter',

            'actionObjectOrderCartRuleAddAfter',
            'actionObjectOrderCartRuleUpdateAfter',

            'actionObjectOrderDetailAddAfter',
            'actionObjectOrderDetailUpdateAfter',

            'actionObjectOrderHistoryAddAfter',
            'actionObjectOrderHistoryUpdateAfter',

            'actionObjectOrderAddAfter',
            'actionObjectOrderUpdateAfter',

            'actionObjectProductAddAfter',
            'actionObjectProductUpdateAfter',
            'actionObjectProductDeleteAfter',

            'actionObjectSpecificPriceAddAfter',
            'actionObjectSpecificPriceUpdateAfter',
            'actionObjectSpecificPriceDeleteAfter',

            'actionObjectStockAvailableAddAfter',
            'actionObjectStockAvailableUpdateAfter',
            'actionObjectStockMvtAddAfter',

            'actionObjectStoreAddAfter',
            'actionObjectStoreUpdateAfter',
            'actionObjectStoreDeleteAfter',

            'actionObjectSupplierAddAfter',
            'actionObjectSupplierUpdateAfter',
            'actionObjectSupplierDeleteAfter',

            'actionObjectWishlistAddAfter',
            'actionObjectWishlistUpdateAfter',
            'actionObjectWishlistDeleteAfter',
        ];
    }
}
