<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\OrderHistoryRepository;

class OrderHistoriesService implements ShopContentServiceInterface
{
    /** @var OrderHistoryRepository */
    private $orderHistoryRepository;

    public function __construct(OrderHistoryRepository $orderHistoryRepository) {
        $this->orderHistoryRepository = $orderHistoryRepository;
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
        $orderHistories = $this->orderHistoryRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($orderHistories)) {
            return [];
        }

        $this->castOrderHistories($orderHistories, $langIso);

        return array_map(function ($orderHistory) {
            return [
                'id' => $orderHistory['id_order_histories'],
                'collection' => Config::COLLECTION_ORDER_HISTORIES,
                'properties' => $orderHistory,
            ];
        }, $orderHistories);
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
        $orderHistories = $this->orderHistoryRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($orderHistories)) {
            return [];
        }

        $this->castOrderHistories($orderHistories, $langIso);

        return array_map(function ($orderHistory) {
            return [
                'id' => $orderHistory['id_order_histories'],
                'collection' => Config::COLLECTION_ORDER_HISTORIES,
                'properties' => $orderHistory,
            ];
        }, $orderHistories);
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
        return (int) $this->orderHistoryRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }

    /**
     * @param array<mixed> $orderHistories
     *
     * @return void
     */
    public function castOrderHistories(&$orderHistories)
    {
        $castedOrderHistories = [];

        foreach ($orderHistories as $orderHistory) {
            $castedOrderHistory = [];
            $castedOrderHistory['id_order_state'] = (int) $orderHistory['id_order_state'];
            $castedOrderHistory['id_order'] = (int) $orderHistory['id_order'];
            $castedOrderHistory['id_order_histories'] = (int) $orderHistory['id_order_histories'];
            $castedOrderHistory['name'] = (string) $orderHistory['name'];
            $castedOrderHistory['template'] = (string) $orderHistory['template'];
            $castedOrderHistory['date_add'] = $orderHistory['date_add'];
            $castedOrderHistory['is_validated'] = (bool) $orderHistory['logable'];
            $castedOrderHistory['is_delivered'] = (bool) $orderHistory['delivery'];
            $castedOrderHistory['is_shipped'] = (bool) $orderHistory['shipped'];
            $castedOrderHistory['is_paid'] = (bool) $orderHistory['paid'];
            $castedOrderHistory['is_deleted'] = (bool) $orderHistory['deleted'];
            $castedOrderHistory['created_at'] = $castedOrderHistory['date_add'];
            $castedOrderHistory['updated_at'] = $castedOrderHistory['date_add'];
            $castedOrderHistories[] = $castedOrderHistory;
        }

        return $castedOrderHistories;
    }
}
