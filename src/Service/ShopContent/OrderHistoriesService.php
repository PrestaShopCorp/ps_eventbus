<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */



namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\OrderHistoryRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
        $result = $this->orderHistoryRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

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
        $result = $this->orderHistoryRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

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
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->orderHistoryRepository->countFullSyncContentLeft($offset, $limit, $langIso);
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
