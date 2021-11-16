<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use Currency;
use Language;
use PrestaShop\Module\PsEventbus\Builder\CarrierBuilder;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

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

    public function __construct(
        ConfigurationRepository $configurationRepository,
        CarrierBuilder $carrierBuilder,
        CarrierRepository $carrierRepository
    ) {
        $this->configurationRepository = $configurationRepository;
        $this->carrierBuilder = $carrierBuilder;
        $this->carrierRepository = $carrierRepository;
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
        $language = new Language($this->configurationRepository->get('PS_LANG_DEFAULT'));
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
        $shippingIncremental = $this->carrierRepository->getShippingIncremental(Config::COLLECTION_CARRIER, $langIso);

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
