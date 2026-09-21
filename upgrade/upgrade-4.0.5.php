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
if (!defined('_PS_VERSION_')) {
    exit;
}

function deleteFolderRecursively($folderPath)
{
    if (!is_dir($folderPath)) {
        return false;
    }

    // select all file, but don't select '.' and '..'
    $files = array_diff(scandir($folderPath), ['.', '..']);

    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;

        if (is_dir($filePath)) {
            deleteFolderRecursively($filePath);
        } else {
            \unlink($filePath);
        }
    }

    return rmdir($folderPath);
}

/**
 * @return bool
 */
function upgrade_module_4_0_5()
{
    try {
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiCarriers.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiCartRules.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiCarts.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiCategories.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiCurrencies.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiCustomProductCarriers.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiCustomers.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiDeletedObjects.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiEmployees.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiGoogleTaxonomies.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiImageTypes.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiImages.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiInfo.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiLanguages.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiManufacturers.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiModules.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiOrders.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiProducts.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiSpecificPrices.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiStocks.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiStores.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiSuppliers.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiThemes.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiTranslations.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/controllers/front/apiWishlists.php');

        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/sql/migrate.sql');

        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Api/CollectorApiClient.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Api/LiveSyncApiClient.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Api/SyncApiClient.php');

        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Exception/HmacException.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Exception/PsAccountsRsaSignDataEmptyException.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Exception/UnauthorizedException.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Exception/WebhookException.php');

        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Formatter/JsonFormatter.php');

        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Handler/ErrorHandler/ErrorHandlerInterface.php');

        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/ConfigurationRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/CountryRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/CustomPriceRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/DeletedObjectsRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/EventbusSyncRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/GoogleTaxonomyRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/OrderDetailsRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/OrderHistoryRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/ProductCarrierRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/ServerInformationRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/ShopRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/StateRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/StockMvtRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/TaxRepository.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Repository/ThemeRepository.php');

        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Service/CacheService.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Service/CompressionService.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Service/DeletedObjectsService.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Service/ProxyService.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Service/ProxyServiceInterface.php');
        \unlink(_PS_MODULE_DIR_ . 'ps_eventbus/src/Service/SpecificPriceService.php');

        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/config/common');
        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/src/Api/Post');
        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/src/Builder');
        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/src/Controller');
        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/src/DTO');
        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/src/Decorator');
        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/src/DependencyInjection');
        deleteFolderRecursively(_PS_MODULE_DIR_ . 'ps_eventbus/src/Provider');
    } finally {
        return true;
    }
}
