<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use Currency;
use PrestaShop\Module\PsEventbus\Builder\CarrierBuilder;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CarrierRepository;
use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;

class CarriersService implements ShopContentServiceInterface
{
    /** @var CarrierRepository */
    private $carrierRepository;

    /** @var ConfigurationRepository */
    private $configurationRepository;

    /** @var CarrierBuilder */
    private $carrierBuilder;

    /** @var LanguageRepository */
    private $languageRepository;

    public function __construct(
        CarrierRepository $carrierRepository,
        ConfigurationRepository $configurationRepository,
        CarrierBuilder $carrierBuilder,
        LanguageRepository $languageRepository
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->configurationRepository = $configurationRepository;
        $this->carrierBuilder = $carrierBuilder;
        $this->languageRepository = $languageRepository;
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
        $currency = new Currency((int) $this->configurationRepository->get('PS_CURRENCY_DEFAULT'));
        
        /** @var array<mixed> $carriers */
        $carriers = $this->carrierRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        /** @var string $psWeightUnit */
        $psWeightUnit = $this->configurationRepository->get('PS_WEIGHT_UNIT');

        /** @var EventBusCarrier[] $eventBusCarriers */
        $eventBusCarriers = $this->carrierBuilder->buildCarriers(
            $carriers,
            $langIso,
            $currency,
            $psWeightUnit
        );

        return array_map(function ($item) {

            return [
                'id' => $item['id_reference'],
                'collection' => Config::COLLECTION_CARRIERS,
                'properties' => $item,
            ];
        }, $eventBusCarriers);
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
        $result = $this->carrierRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $currency = new \Currency((int) $this->configurationRepository->get('PS_CURRENCY_DEFAULT'));

        /** @var string $psWeightUnit */
        $psWeightUnit = $this->configurationRepository->get('PS_WEIGHT_UNIT');

        /** @var EventBusCarrier[] $eventBusCarriers */
        $eventBusCarriers = $this->carrierBuilder->buildCarriers(
            $result,
            $langIso,
            $currency,
            $psWeightUnit
        );

        return array_map(function ($item) {
            return [
                'id' => $item['id_reference'],
                'collection' => Config::COLLECTION_CARRIERS,
                'properties' => $item,
            ];
        }, $eventBusCarriers);
    }

    /**
     * @param int $offset
     * @param string $langIso
     * @param bool $debug
     *
     * @return int
     */
    public function countFullSyncContentLeft($offset, $langIso, $debug)
    {
        return (int) $this->carrierRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }
}
