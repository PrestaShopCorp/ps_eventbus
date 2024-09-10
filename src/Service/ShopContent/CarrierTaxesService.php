<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Helper\CarrierHelper;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CarrierRepository;

class CarrierTaxesService implements ShopContentServiceInterface
{
    /** @var CarrierRepository */
    private $carrierRepository;

    public function __construct(CarrierRepository $carrierRepository)
    {
        $this->carrierRepository = $carrierRepository;
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

        $carrierTaxes = [];

        foreach ($result as $carrierData) {
            $carrierTaxes = array_merge($carrierTaxes, CarrierHelper::buildCarrierTaxes($carrierData));
        }


        $this->castCarrierTaxes($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'] . '-' . $item['id_zone'] . '-' . $item['id_range'],
                'collection' => Config::COLLECTION_CARRIER_TAXES,
                'properties' => $item,
            ];
        }, $carrierTaxes);
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

        $carrierTaxes = [];

        foreach ($result as $carrierData) {
            $carrierTaxes = array_merge($carrierTaxes, CarrierHelper::buildCarrierDetails($carrierData));
        }

        $this->castCarrierTaxes($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'] . '-' . $item['id_zone'] . '-' . $item['id_range'],
                'collection' => Config::COLLECTION_CARRIER_TAXES,
                'properties' => $item,
            ];
        }, $carrierTaxes);
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
     * @param array<mixed> $carrierTaxes
     *
     * @return void
     */
    private function castCarrierTaxes(&$carrierTaxes)
    {
        foreach ($carrierTaxes as &$carrierTaxe) {
            $carrierTaxe['id_reference'] = (string) $carrierTaxe['id_reference'];
            $carrierTaxe['id_zone'] = (string) $carrierTaxe['id_zone'];
            $carrierTaxe['id_range'] = (string) $carrierTaxe['id_range'];
            $carrierTaxe['id_carrier_tax'] = (string) $carrierTaxe['id_carrier_tax'];
            $carrierTaxe['country_ids'] = (string) $carrierTaxe['country_ids'];
            $carrierTaxe['state_ids'] = (string) $carrierTaxe['state_ids'];
            $carrierTaxe['tax_rate'] = (float) $carrierTaxe['tax_rate'];
        }
    }
}
