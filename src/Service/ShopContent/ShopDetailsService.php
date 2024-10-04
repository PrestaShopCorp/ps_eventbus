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
use PrestaShop\Module\PsEventbus\Repository\ShopRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ShopDetailsService implements ShopContentServiceInterface
{
    /** @var CurrenciesService */
    private $currenciesService;

    /** @var LanguagesService */
    private $languagesService;

    /** @var \Context */
    private $context;

    /** @var ShopRepository */
    private $shopRepository;

    /**
     * @param \Context $context
     * @param ShopRepository $shopRepository
     * @param LanguagesService $languagesService
     * @param CurrenciesService $currenciesService
     *
     * @return void
     */
    public function __construct(
        \Context $context,
        ShopRepository $shopRepository,
        LanguagesService $languagesService,
        CurrenciesService $currenciesService
    ) {
        $this->currenciesService = $currenciesService;
        $this->languagesService = $languagesService;
        $this->shopRepository = $shopRepository;
        $this->context = $context;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $explainSql)
    {
        $langId = !empty($langIso) ? (int) \Language::getIdByIso($langIso) : null;

        /* This file is created on installation and never modified.
        As php doesn't allow to retrieve the creation date of a file or folder,
        we use the modification date of this file to get the installation date of the shop */
        $filename = './img/admin/enabled.gif';
        $folderCreatedAt = null;
        if (file_exists($filename)) {
            $folderCreatedAt = date('Y-m-d H:i:s', (int) filectime($filename));
        }

        if ($this->context->link === null) {
            throw new \PrestaShopException('No link context');
        }

        return [
            [
                'id' => '1',
                'collection' => Config::COLLECTION_SHOP_DETAILS,
                'properties' => [
                    'created_at' => $this->shopRepository->getCreatedAt(),
                    'folder_created_at' => $folderCreatedAt,
                    'cms_version' => _PS_VERSION_,
                    'url_is_simplified' => \Configuration::get('PS_REWRITING_SETTINGS') == '1',
                    'cart_is_persistent' => \Configuration::get('PS_CART_FOLLOWING') == '1',
                    'default_language' => $this->languagesService->getDefaultLanguageIsoCode(),
                    'languages' => implode(';', $this->languagesService->getLanguagesIsoCodes()),
                    'default_currency' => $this->currenciesService->getDefaultCurrencyIsoCode(),
                    'currencies' => implode(';', $this->currenciesService->getCurrenciesIsoCodes()),
                    'weight_unit' => \Configuration::get('PS_WEIGHT_UNIT'),
                    'distance_unit' => \Configuration::get('PS_BASE_DISTANCE_UNIT'),
                    'volume_unit' => \Configuration::get('PS_VOLUME_UNIT'),
                    'dimension_unit' => \Configuration::get('PS_DIMENSION_UNIT'),
                    'timezone' => \Configuration::get('PS_TIMEZONE'),
                    'is_order_return_enabled' => \Configuration::get('PS_ORDER_RETURN') == '1',
                    'order_return_nb_days' => (int) \Configuration::get('PS_ORDER_RETURN_NB_DAYS'),
                    'php_version' => phpversion(),
                    'http_server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '',
                    'url' => $this->context->link->getPageLink('index', null, $langId),
                    'ssl' => \Configuration::get('PS_SSL_ENABLED') == '1',
                    'multi_shop_count' => $this->shopRepository->getMultiShopCount(),
                    'country_code' => $this->shopRepository->getShopCountryCode(),
                ],
            ],
        ];
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $explainSql)
    {
        return [];
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
        return 0;
    }
}
