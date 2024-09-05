<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

use Context;
use DbQuery;
use Language;
use PrestaShopException;

class CarrierRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'carrier';

    /**
     * @param string $langIso
     *
     * @return mixed
     *
     * @throws PrestaShopException
     */
    public function generateBaseQuery($langIso)
    { 
        $langId = (int) Language::getIdByIso($langIso);
        $context = Context::getContext();

        if ($context === null) {
            throw new PrestaShopException('Context is null');
        }

        if ($context->shop === null) {
            throw new PrestaShopException('No shop context');
        }

        $this->query = new DbQuery();

        $this->query->from('carrier', 'c');
        $this->query->select('c.id_carrier');
        $this->query->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . $langId);
        $this->query->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $this->query->where('cs.id_shop = ' . $context->shop->id);
        $this->query->where('deleted=0');
    }
    
    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {

    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {

    }
    
    /**
     * @param int $offset
     * @param string $langIso
     * @param bool $debug
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $langIso, $debug)
    {

    }

    /**
     * @param \Carrier $carrierObj
     *
     * @return array<mixed>|false
     */
    public function getDeliveryPriceByRange(\Carrier $carrierObj)
    {
        $rangeTable = $carrierObj->getRangeTable();
        switch ($rangeTable) {
            case 'range_weight':
                return $this->getCarrierByWeightRange($carrierObj, 'range_weight');
            case 'range_price':
                return $this->getCarrierByPriceRange($carrierObj, 'range_price');
            default:
                return false;
        }
    }

    /**
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array<mixed>
     */
    private function getCarrierByPriceRange(
        \Carrier $carrierObj,
        $rangeTable
    ) {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_price']]['id_range_price'] = $range['id_range_price'];
            $filteredRanges[$range['id_range_price']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_price']]['zones'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_price']]['zones'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
    }

    /**
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array<mixed>
     */
    private function getCarrierByWeightRange(
        \Carrier $carrierObj,
        $rangeTable
    ) {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_weight']]['id_range_weight'] = $range['id_range_weight'];
            $filteredRanges[$range['id_range_weight']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_weight']]['zones'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_weight']]['zones'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return \DbQuery
     */
    private function getAllCarriersQuery($offset, $limit, $langId)
    {
        $query = new \DbQuery();
        $query->from('carrier', 'c');
        $query->select('c.id_carrier');
        $query->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . (int) $langId);
        $query->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $query->where('cs.id_shop = ' . $this->shopId);
        $query->where('deleted=0');
        $query->limit($limit, $offset);

        return $query;
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getShippingIncremental($type, $langIso)
    {
        $query = new \DbQuery();
        $query->from(IncrementalSyncRepository::INCREMENTAL_SYNC_TABLE, 'aic');
        $query->leftJoin(EventbusSyncRepository::TYPE_SYNC_TABLE_NAME, 'ts', 'ts.type = aic.type');
        $query->where('aic.type = "' . pSQL($type) . '"');
        $query->where('ts.id_shop = ' . $this->shopId);
        $query->where('ts.lang_iso = "' . pSQL($langIso) . '"');

        return $this->db->executeS($query);
    }

    /**
     * @param array<mixed> $deliveryPriceByRange
     *
     * @return false|\RangeWeight|\RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getCarrierRange($deliveryPriceByRange)
    {
        if (isset($deliveryPriceByRange['id_range_weight'])) {
            return new \RangeWeight($deliveryPriceByRange['id_range_weight']);
        }
        if (isset($deliveryPriceByRange['id_range_price'])) {
            return new \RangePrice($deliveryPriceByRange['id_range_price']);
        }

        return false;
    }

    /**
     * @param int[] $carrierIds
     * @param int $langId
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCarrierProperties($carrierIds, $langId)
    {
        if (!$carrierIds) {
            return [];
        }
        $query = new \DbQuery();
        $query->from('carrier', 'c');
        $query->select('c.*, cl.delay');
        $query->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . (int) $langId);
        $query->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $query->where('c.id_carrier IN (' . implode(',', array_map('intval', $carrierIds)) . ')');
        $query->where('cs.id_shop = ' . $this->shopId);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getAllCarrierProperties($offset, $limit, $langId)
    {
        return $this->db->executeS($this->getAllCarriersQuery($offset, $limit, $langId));
    }

    /**
     * @param int $offset
     * @param int $langId
     *
     * @return int
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getRemainingCarriersCount($offset, $langId)
    {
        $carriers = $this->getAllCarrierProperties($offset, 1, $langId);

        if (!is_array($carriers) || empty($carriers)) {
            return 0;
        }

        return count($carriers);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langId)
    {
        $query = $this->getAllCarriersQuery($offset, $limit, $langId);
        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }
}
