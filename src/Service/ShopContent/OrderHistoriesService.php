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
        $result = $this->orderHistoryRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }
 
        $this->castOrderHistories($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_order_history'],
                'collection' => Config::COLLECTION_ORDER_HISTORIES,
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
        $result = $this->orderHistoryRepository->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castOrderHistories($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_order_history'],
                'collection' => Config::COLLECTION_ORDER_HISTORIES,
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
        return (int) $this->orderHistoryRepository->countFullSyncContentLeft($offset, $langIso, $debug);
    }

    /**
     * @param array<mixed> $orderHistories
     *
     * @return void
     */
    private function castOrderHistories(&$orderHistories)
    {
        foreach ($orderHistories as &$orderHistory) {
            $orderHistory['id_order_state'] = (int) $orderHistory['id_order_state'];
            $orderHistory['id_order'] = (int) $orderHistory['id_order'];
            $orderHistory['id_order_history'] = (int) $orderHistory['id_order_history'];
            $orderHistory['name'] = (string) $orderHistory['name'];
            $orderHistory['template'] = (string) $orderHistory['template'];
            $orderHistory['date_add'] = $orderHistory['date_add'];
            $orderHistory['is_validated'] = (bool) $orderHistory['is_validated'];
            $orderHistory['is_delivered'] = (bool) $orderHistory['is_delivered'];
            $orderHistory['is_shipped'] = (bool) $orderHistory['is_shipped'];
            $orderHistory['is_paid'] = (bool) $orderHistory['is_paid'];
            $orderHistory['is_deleted'] = (bool) $orderHistory['is_deleted'];
            $orderHistory['created_at'] = $orderHistory['date_add'];
            $orderHistory['updated_at'] = $orderHistory['date_add'];
        }
    }
}
