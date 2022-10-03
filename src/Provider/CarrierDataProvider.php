<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use Currency;
use Language;
use PrestaShop\Module\PsEventbus\Builder\CarrierBuilder;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;

class CarrierDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;

    /**
     * @var CarrierBuilder
     */
    private $carrierBuilder;

    /**
     * @var CarrierRepository
     */
    private $carrierRepository;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    public function __construct(
        ConfigurationRepository $configurationRepository,
        CarrierBuilder $carrierBuilder,
        CarrierRepository $carrierRepository,
        LanguageRepository $languageRepository
    ) {
        $this->configurationRepository = $configurationRepository;
        $this->carrierBuilder = $carrierBuilder;
        $this->carrierRepository = $carrierRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);
        $language = new Language($langId);
        $currency = new Currency($this->configurationRepository->get('PS_CURRENCY_DEFAULT'));

        $carriers = $this->carrierRepository->getAllCarrierProperties($offset, $limit, $language->id);

        /** @var EventBusCarrier[] $eventBusCarriers */
        $eventBusCarriers = $this->carrierBuilder->buildCarriers(
            $carriers,
            $language,
            $currency,
            $this->configurationRepository->get('PS_WEIGHT_UNIT')
        );

        return $eventBusCarriers;
    }

    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $shippingIncremental = $this->carrierRepository->getShippingIncremental(Config::COLLECTION_CARRIERS, $langIso);

        if (!$shippingIncremental) {
            return [];
        }

        $language = new Language($this->configurationRepository->get('PS_LANG_DEFAULT'));
        $currency = new Currency($this->configurationRepository->get('PS_CURRENCY_DEFAULT'));
        $carrierIds = array_column($shippingIncremental, 'id_object');
        $carriers = $this->carrierRepository->getCarrierProperties($carrierIds, $language->id);

        /** @var EventBusCarrier[] $eventBusCarriers */
        $eventBusCarriers = $this->carrierBuilder->buildCarriers(
            $carriers,
            $language,
            $currency,
            $this->configurationRepository->get('PS_WEIGHT_UNIT')
        );

        return $eventBusCarriers;
    }

    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->carrierRepository->getRemainingCarriersCount($offset, $langIso);
    }
}
