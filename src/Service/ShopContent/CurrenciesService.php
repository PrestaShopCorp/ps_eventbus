<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CurrencyRepository;

class CurrenciesService implements ShopContentServiceInterface
{
    /** @var CurrencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
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
        $result = $this->currencyRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCurrencies($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_currency'],
                'collection' => Config::COLLECTION_CURRENCIES,
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
        $result = $this->currencyRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCurrencies($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_currency'],
                'collection' => Config::COLLECTION_CURRENCIES,
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
        return $this->currencyRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $currencies
     *
     * @return void
     */
    private function castCurrencies(&$currencies)
    {
        foreach ($currencies as &$currency) {
            $currency['id_currency'] = (int) $currency['id_currency'];
            $currency['conversion_rate'] = (float) $currency['conversion_rate'];
            $currency['deleted'] = (bool) $currency['deleted'];
            $currency['active'] = (bool) $currency['active'];
    
            // https://github.com/PrestaShop/PrestaShop/commit/37807f66b40b0cebb365ef952e919be15e9d6b2f#diff-3f41d3529ffdbfd1b994927eb91826a32a0560697025a734cf128a2c8e092a45R124
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
                $currency['precision'] = (int) $currency['precision'];
            }
        }
    }

    /**
     * @return array<mixed>
     */
    public function getCurrenciesIsoCodes()
    {
        $currencies = \Currency::getCurrencies();

        return array_map(function ($currency) {
            return $currency['iso_code'];
        }, $currencies);
    }

    /**
     * @return string
     */
    public function getDefaultCurrencyIsoCode()
    {
        $currency = \Currency::getDefaultCurrency();

        return $currency instanceof \Currency ? $currency->iso_code : '';
    }
}
