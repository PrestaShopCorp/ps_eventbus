<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\OrderHistoryRepository;

class OrderHistoriesService implements ShopContentServiceInterface
{
    /** @var OrderHistoryRepository */
    private $orderHistoryRepository;

    public function __construct(OrderHistoryRepository $orderHistoryRepository)
    {
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

        $this->castOrderHistories($orderHistories);

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

        $this->castOrderHistories($orderHistories);

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
        foreach ($orderHistories as &$orderHistory) {
            $orderHistory['id_order_state'] = (int) $orderHistory['id_order_state'];
            $orderHistory['id_order'] = (int) $orderHistory['id_order'];
            $orderHistory['id_order_histories'] = (int) $orderHistory['id_order_histories'];
            $orderHistory['name'] = (string) $orderHistory['name'];
            $orderHistory['template'] = (string) $orderHistory['template'];
            $orderHistory['date_add'] = $orderHistory['date_add'];
            $orderHistory['is_validated'] = (bool) $orderHistory['logable'];
            $orderHistory['is_delivered'] = (bool) $orderHistory['delivery'];
            $orderHistory['is_shipped'] = (bool) $orderHistory['shipped'];
            $orderHistory['is_paid'] = (bool) $orderHistory['paid'];
            $orderHistory['is_deleted'] = (bool) $orderHistory['deleted'];
            $orderHistory['created_at'] = $orderHistory['date_add'];
            $orderHistory['updated_at'] = $orderHistory['date_add'];
        }
    }
}
