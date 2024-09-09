<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CarrierDetailRepository;

class CarrierDetailsService implements ShopContentServiceInterface
{
    /** @var CarrierDetailRepository */
    private $carrierDetailRepository;

    /** @var ConfigurationRepository */
    private $configurationRepository;


    public function __construct(
        CarrierDetailRepository $carrierDetailRepository,
        ConfigurationRepository $configurationRepository
    ) {
        $this->carrierDetailRepository = $carrierDetailRepository;
        $this->configurationRepository = $configurationRepository;
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
        $currency = new \Currency((int) $this->configurationRepository->get('PS_CURRENCY_DEFAULT'));

        /** @var array<mixed> $carriers */
        $carriers = $this->carrierDetailRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        /** @var string $psWeightUnit */
        $psWeightUnit = $this->configurationRepository->get('PS_WEIGHT_UNIT');

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
        $result = $this->carrierDetailRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $currency = new \Currency((int) $this->configurationRepository->get('PS_CURRENCY_DEFAULT'));

        /** @var string $psWeightUnit */
        $psWeightUnit = $this->configurationRepository->get('PS_WEIGHT_UNIT');

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
        return (int) $this->carrierDetailRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }
}
