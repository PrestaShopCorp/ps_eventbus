<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CarrierRepository;

class CarriersService implements ShopContentServiceInterface
{
    /** @var CarrierRepository */
    private $carrierRepository;

    /** @var ConfigurationRepository */
    private $configurationRepository;

    public function __construct(
        CarrierRepository $carrierRepository,
        ConfigurationRepository $configurationRepository
    ) {
        $this->carrierRepository = $carrierRepository;
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
        $result = $this->carrierRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCarriers($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'],
                'collection' => Config::COLLECTION_CARRIERS,
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
        $result = $this->carrierRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCarriers($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'],
                'collection' => Config::COLLECTION_CARRIERS,
                'properties' => $item,
            ];
        }, $result);
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

    /**
     * @param array<mixed> $carriers
     *
     * @return void
     */
    private function castCarriers(&$carriers)
    {
        $context = \Context::getContext();

        if ($context === null) {
            throw new \PrestaShopException('Context is null');
        }

        $currency = new \Currency((int) $this->configurationRepository->get('PS_CURRENCY_DEFAULT'));
        $freeShippingStartsAtPrice = (float) $this->configurationRepository->get('PS_SHIPPING_FREE_PRICE');
        $freeShippingStartsAtWeight = (float) $this->configurationRepository->get('PS_SHIPPING_FREE_WEIGHT');

        /** @var string $psWeightUnit */
        $psWeightUnit = $this->configurationRepository->get('PS_WEIGHT_UNIT');

        foreach ($carriers as &$carrier) {
            $carrierTaxesRatesGroupId = \Carrier::getIdTaxRulesGroupByIdCarrier((int) $carrier['id_carrier'], \Context::getContext());

            $shippingHandling = 0.0;

            if ($carrier['shipping_handling']) {
                $shippingHandling = (float) $this->configurationRepository->get('PS_SHIPPING_HANDLING');
            }

            $carrier['id_carrier'] = (string) $carrier['id_carrier'];
            $carrier['id_reference'] = (string) $carrier['id_reference'];
            $carrier['name'] = (string) $carrier['name'];
            $carrier['carrier_taxes_rates_group_id'] = (string) $carrierTaxesRatesGroupId;
            $carrier['url'] = (string) $carrier['url'];
            $carrier['active'] = (bool) $carrier['active'];
            $carrier['deleted'] = (bool) $carrier['deleted'];
            $carrier['shipping_handling'] = (float) $shippingHandling;
            $carrier['free_shipping_starts_at_price'] = (float) $freeShippingStartsAtPrice;
            $carrier['free_shipping_starts_at_weight'] = (float) $freeShippingStartsAtWeight;
            $carrier['disable_carrier_when_out_of_range'] = (bool) $carrier['range_behavior'];
            $carrier['is_module'] = (bool) $carrier['is_module'];
            $carrier['is_free'] = (bool) $carrier['is_free'];
            $carrier['shipping_external'] = (bool) $carrier['shipping_external'];
            $carrier['need_range'] = (bool) $carrier['need_range'];
            $carrier['external_module_name'] = (string) $carrier['external_module_name'];
            $carrier['max_width'] = (float) $carrier['max_width'];
            $carrier['max_height'] = (float) $carrier['max_height'];
            $carrier['max_depth'] = (float) $carrier['max_depth'];
            $carrier['max_weight'] = (float) $carrier['max_weight'];
            $carrier['grade'] = (int) $carrier['grade'];
            $carrier['delay'] = (string) $carrier['delay'];
            $carrier['currency'] = (string) $currency->iso_code;
            $carrier['weight_unit'] = (string) $psWeightUnit;
        }
    }
}
