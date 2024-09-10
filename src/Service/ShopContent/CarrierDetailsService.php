<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Helper\CarrierHelper;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CarrierRepository;

class CarrierDetailsService implements ShopContentServiceInterface
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

        $carrierDetails = [];

        foreach ($result as $carrierData) {
            $carrierDetails = array_merge($carrierDetails, CarrierHelper::buildCarrierDetails($carrierData));
        }

        $this->castCarrierDetails($carrierDetails);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'] . '-' . $item['id_zone'] . '-' . $item['shipping_method'] . '-' . $item['id_range'],
                'collection' => Config::COLLECTION_CARRIER_DETAILS,
                'properties' => $item,
            ];
        }, $carrierDetails);
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

        $carrierDetails = [];

        foreach ($result as $carrierData) {
            $carrierDetails = array_merge($carrierDetails, CarrierHelper::buildCarrierDetails($carrierData));
        }

        $this->castCarrierDetails($carrierDetails);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['id_reference'] . '-' . $item['id_zone'] . '-' . $item['shipping_method'] . '-' . $item['id_range'],
                'collection' => Config::COLLECTION_CARRIER_DETAILS,
                'properties' => $item,
            ];
        }, $carrierDetails);
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
     * @param array<mixed> $carrierDetails
     *
     * @return void
     */
    private function castCarrierDetails(&$carrierDetails)
    {
        foreach ($carrierDetails as &$carrierDetail) {
            $carrierDetail['id_reference'] = (string) $carrierDetail['id_reference'];
            $carrierDetail['id_zone'] = (string) $carrierDetail['id_zone'];
            $carrierDetail['id_range'] = (string) $carrierDetail['id_range'];
            $carrierDetail['id_carrier_detail'] = (string) $carrierDetail['id_carrier_detail'];
            $carrierDetail['shipping_method'] = (string) $carrierDetail['shipping_method'];
            $carrierDetail['delimiter1'] = (float) $carrierDetail['delimiter1'];
            $carrierDetail['delimiter2'] = (float) $carrierDetail['delimiter2'];
            $carrierDetail['country_ids'] = (string) $carrierDetail['country_ids'];
            $carrierDetail['state_ids'] = (string) $carrierDetail['state_ids'];
            $carrierDetail['price'] = (float) $carrierDetail['price'];
        }
    }
}
