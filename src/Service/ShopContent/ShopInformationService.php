<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\ShopRepository;

class ShopInformationService implements ShopContentServiceInterface
{
    /** @var CurrenciesService */
    private $currenciesService;

    /** @var LanguageRepository */
    private $languageRepository;

    /** @var ConfigurationRepository */
    private $configurationRepository;

    /** @var \Context */
    private $context;

    /** @var ShopRepository */
    private $shopRepository;

    /**
     * @param \Context $context
     * @param LanguageRepository $languageRepository
     * @param ConfigurationRepository $configurationRepository
     * @param ShopRepository $shopRepository
     * @param CurrenciesService $currenciesService
     *
     * @return void
     */
    public function __construct(
        \Context $context,
        LanguageRepository $languageRepository,
        ConfigurationRepository $configurationRepository,
        ShopRepository $shopRepository,
        CurrenciesService $currenciesService
    ) {
        $this->currenciesService = $currenciesService;
        $this->languageRepository = $languageRepository;
        $this->configurationRepository = $configurationRepository;
        $this->shopRepository = $shopRepository;
        $this->context = $context;
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
                'collection' => Config::COLLECTION_SHOP_INFORMATION,
                'properties' => [
                    'created_at' => $this->shopRepository->getCreatedAt(),
                    'folder_created_at' => $folderCreatedAt,
                    'cms_version' => _PS_VERSION_,
                    'url_is_simplified' => $this->configurationRepository->get('PS_REWRITING_SETTINGS') == '1',
                    'cart_is_persistent' => $this->configurationRepository->get('PS_CART_FOLLOWING') == '1',
                    'default_language' => $this->languageRepository->getDefaultLanguageIsoCode(),
                    'languages' => implode(';', $this->languageRepository->getLanguagesIsoCodes()),
                    'default_currency' => $this->currenciesService->getDefaultCurrencyIsoCode(),
                    'currencies' => implode(';', $this->currenciesService->getCurrenciesIsoCodes()),
                    'weight_unit' => $this->configurationRepository->get('PS_WEIGHT_UNIT'),
                    'distance_unit' => $this->configurationRepository->get('PS_BASE_DISTANCE_UNIT'),
                    'volume_unit' => $this->configurationRepository->get('PS_VOLUME_UNIT'),
                    'dimension_unit' => $this->configurationRepository->get('PS_DIMENSION_UNIT'),
                    'timezone' => $this->configurationRepository->get('PS_TIMEZONE'),
                    'is_order_return_enabled' => $this->configurationRepository->get('PS_ORDER_RETURN') == '1',
                    'order_return_nb_days' => (int) $this->configurationRepository->get('PS_ORDER_RETURN_NB_DAYS'),
                    'php_version' => phpversion(),
                    'http_server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '',
                    'url' => $this->context->link->getPageLink('index', null, $langId),
                    'ssl' => $this->configurationRepository->get('PS_SSL_ENABLED') == '1',
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
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
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
