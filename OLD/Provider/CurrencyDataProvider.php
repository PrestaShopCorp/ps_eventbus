<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\CurrencyDecorator;
use PrestaShop\Module\PsEventbus\Repository\CurrencyRepository;

class CurrencyDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    /**
     * @var CurrencyDecorator
     */
    private $currencyDecorator;

    public function __construct(CurrencyRepository $currencyRepository, CurrencyDecorator $currencyDecorator)
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyDecorator = $currencyDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $currencies = $this->currencyRepository->getCurrencies($offset, $limit);

        if (!is_array($currencies)) {
            return [];
        }
        $this->currencyDecorator->decorateCurrencies($currencies);

        return array_map(function ($currency) {
            return [
                'id' => $currency['id_currency'],
                'collection' => Config::COLLECTION_CURRENCIES,
                'properties' => $currency,
            ];
        }, $currencies);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->currencyRepository->getRemainingCurrenciesCount($offset);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $objectIds
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $currencies = $this->currencyRepository->getCurrenciesIncremental($limit, $objectIds);

        if (!is_array($currencies)) {
            return [];
        }
        $this->currencyDecorator->decorateCurrencies($currencies);

        return array_map(function ($currency) {
            return [
                'id' => $currency['id_currency'],
                'collection' => Config::COLLECTION_CURRENCIES,
                'properties' => $currency,
            ];
        }, $currencies);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->currencyRepository->getQueryForDebug($offset, $limit);
    }
}
