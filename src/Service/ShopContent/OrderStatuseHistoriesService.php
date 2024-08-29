<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\OrderStatuseHistoryRepository;

class OrdersStatuseHistoriesService implements ShopContentServiceInterface
{
    /** @var OrderStatuseHistoriesRepository */
    private $orderStatuseHistoryRepository;

    public function __construct(OrderStatuseHistoryRepository $orderStatuseHistoryRepository) {
        $this->orderStatuseHistoryRepository = $orderStatuseHistoryRepository;
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
        $orderStatuseHistories = $this->orderStatuseHistoryRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($orderStatuseHistories)) {
            return [];
        }

        $this->castOrders($orderStatuseHistories, $langIso);

        return array_map(function ($orderStatuseHistory) {
            return [
                'id' => $orderStatuseHistory['id_order_history'],
                'collection' => Config::COLLECTION_ORDER_STATUS_HISTORIES,
                'properties' => $orderStatuseHistory,
            ];
        }, $orderStatuseHistories);
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
        $orderStatuseHistories = $this->orderStatuseHistoryRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($orderStatuseHistories)) {
            return [];
        }

        $this->castOrders($orderStatuseHistories, $langIso);

        return array_map(function ($orderStatuseHistory) {
            return [
                'id' => $orderStatuseHistory['id_order_history'],
                'collection' => Config::COLLECTION_ORDER_STATUS_HISTORIES,
                'properties' => $orderStatuseHistory,
            ];
        }, $orderStatuseHistories);
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
        return (int) $this->orderStatuseHistoryRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }

    /**
     * @param array<mixed> $orderStatuseHistories
     * @param string $langIso
     *
     * @return void
     */
    public function castOrders(&$orderStatuseHistories, $langIso)
    {
        $orderStatuseHistories = [];

        foreach ($orderStatuseHistories as $orderStatuseHistory) {
            $castedOrderStatus = [];
            $castedOrderStatus['id_order_state'] = (int) $orderStatuseHistory['id_order_state'];
            $castedOrderStatus['id_order'] = (int) $orderStatuseHistory['id_order'];
            $castedOrderStatus['id_order_history'] = (int) $orderStatuseHistory['id_order_history'];
            $castedOrderStatus['name'] = (string) $orderStatuseHistory['name'];
            $castedOrderStatus['template'] = (string) $orderStatuseHistory['template'];
            $castedOrderStatus['date_add'] = $orderStatuseHistory['date_add'];
            $castedOrderStatus['is_validated'] = (bool) $orderStatuseHistory['logable'];
            $castedOrderStatus['is_delivered'] = (bool) $orderStatuseHistory['delivery'];
            $castedOrderStatus['is_shipped'] = (bool) $orderStatuseHistory['shipped'];
            $castedOrderStatus['is_paid'] = (bool) $orderStatuseHistory['paid'];
            $castedOrderStatus['is_deleted'] = (bool) $orderStatuseHistory['deleted'];
            $castedOrderStatus['created_at'] = $castedOrderStatus['date_add'];
            $castedOrderStatus['updated_at'] = $castedOrderStatus['date_add'];
            $castedOrderStatuses[] = $castedOrderStatus;
        }

        return $castedOrderStatuses;
    }
}
