<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\OrderStatusHistoryRepository;

class OrderStatusHistoriesService implements ShopContentServiceInterface
{
    /** @var OrderStatusHistoryRepository */
    private $orderStatusHistoryRepository;

    public function __construct(OrderStatusHistoryRepository $orderStatusHistoryRepository) {
        $this->orderStatusHistoryRepository = $orderStatusHistoryRepository;
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
        $orderHistories = $this->orderStatusHistoryRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($orderHistories)) {
            return [];
        }

        $this->castOrders($orderHistories, $langIso);

        return array_map(function ($orderStatusHistory) {
            return [
                'id' => $orderStatusHistory['id_order_history'],
                'collection' => Config::COLLECTION_ORDER_STATUS_HISTORIES,
                'properties' => $orderStatusHistory,
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
        $orderHistories = $this->orderStatusHistoryRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($orderHistories)) {
            return [];
        }

        $this->castOrders($orderHistories, $langIso);

        return array_map(function ($orderStatusHistory) {
            return [
                'id' => $orderStatusHistory['id_order_history'],
                'collection' => Config::COLLECTION_ORDER_STATUS_HISTORIES,
                'properties' => $orderStatusHistory,
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
        return (int) $this->orderStatusHistoryRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }

    /**
     * @param array<mixed> $orderHistories
     * @param string $langIso
     *
     * @return void
     */
    public function castOrders(&$orderStatusHistories, $langIso)
    {
        $castedOrderStatusHistories = [];

        foreach ($orderStatusHistories as $orderStatusHistory) {
            $castedOrderStatusHistory = [];
            $castedOrderStatusHistory['id_order_state'] = (int) $orderStatusHistory['id_order_state'];
            $castedOrderStatusHistory['id_order'] = (int) $orderStatusHistory['id_order'];
            $castedOrderStatusHistory['id_order_history'] = (int) $orderStatusHistory['id_order_history'];
            $castedOrderStatusHistory['name'] = (string) $orderStatusHistory['name'];
            $castedOrderStatusHistory['template'] = (string) $orderStatusHistory['template'];
            $castedOrderStatusHistory['date_add'] = $orderStatusHistory['date_add'];
            $castedOrderStatusHistory['is_validated'] = (bool) $orderStatusHistory['logable'];
            $castedOrderStatusHistory['is_delivered'] = (bool) $orderStatusHistory['delivery'];
            $castedOrderStatusHistory['is_shipped'] = (bool) $orderStatusHistory['shipped'];
            $castedOrderStatusHistory['is_paid'] = (bool) $orderStatusHistory['paid'];
            $castedOrderStatusHistory['is_deleted'] = (bool) $orderStatusHistory['deleted'];
            $castedOrderStatusHistory['created_at'] = $castedOrderStatusHistory['date_add'];
            $castedOrderStatusHistory['updated_at'] = $castedOrderStatusHistory['date_add'];
            $castedOrderStatusHistories[] = $castedOrderStatusHistory;
        }

        return $castedOrderStatusHistories;
    }
}
