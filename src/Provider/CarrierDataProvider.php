<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Builder\CarrierBuilder;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface as ProviderPaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;

class CarrierDataProvider implements ProviderPaginatedApiDataProviderInterface
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
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $currency = new \Currency((int) $this->configurationRepository->get('PS_CURRENCY_DEFAULT'));

        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);
        /** @var array $carriers */
        $carriers = $this->carrierRepository->getAllCarrierProperties($offset, $limit, $langId);

        /** @var string $configurationPsWeightUnit */
        $configurationPsWeightUnit = $this->configurationRepository->get('PS_WEIGHT_UNIT');
        /** @var EventBusCarrier[] $eventBusCarriers */
        $eventBusCarriers = $this->carrierBuilder->buildCarriers(
            $carriers,
            $langId,
            $currency,
            $configurationPsWeightUnit
        );

        return $eventBusCarriers;
    }

    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        /** @var array $shippingIncremental */
        $shippingIncremental = $this->carrierRepository->getShippingIncremental(Config::COLLECTION_CARRIERS, $langIso);

        if (!$shippingIncremental) {
            return [];
        }

        $currency = new \Currency((int) $this->configurationRepository->get('PS_CURRENCY_DEFAULT'));

        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        $carrierIds = array_column($shippingIncremental, 'id_object');
        /** @var array $carriers */
        $carriers = $this->carrierRepository->getCarrierProperties($carrierIds, $langId);

        /** @var string $configurationPsWeightUnit */
        $configurationPsWeightUnit = $this->configurationRepository->get('PS_WEIGHT_UNIT');
        /** @var EventBusCarrier[] $eventBusCarriers */
        $eventBusCarriers = $this->carrierBuilder->buildCarriers(
            $carriers,
            $langId,
            $currency,
            $configurationPsWeightUnit
        );

        return $eventBusCarriers;
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        return (int) $this->carrierRepository->getRemainingCarriersCount($offset, $langId);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        return $this->carrierRepository->getQueryForDebug($offset, $limit, $langId);
    }
}
