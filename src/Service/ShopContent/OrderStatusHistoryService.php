<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\OrderStatusHistoryRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderStatusHistoryService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var OrderStatusHistoryRepository */
    private $orderStatusHistoryRepository;

    public function __construct(OrderStatusHistoryRepository $orderStatusHistoryRepository)
    {
        $this->orderStatusHistoryRepository = $orderStatusHistoryRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->orderStatusHistoryRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castOrderStatusHistories($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_ORDER_STATUS_HISTORY,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        $result = $this->orderStatusHistoryRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castOrderStatusHistories($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_ORDER_STATUS_HISTORY, $result, $deletedContents);
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
        return $this->orderStatusHistoryRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $orderStatusHistories
     *
     * @return void
     */
    private function castOrderStatusHistories(&$orderStatusHistories)
    {
        foreach ($orderStatusHistories as &$orderStatusHistory) {
            $orderStatusHistory['id_order_state'] = (int) $orderStatusHistory['id_order_state'];
            $orderStatusHistory['id_order'] = (int) $orderStatusHistory['id_order'];
            $orderStatusHistory['id_order_history'] = (int) $orderStatusHistory['id_order_history'];
            $orderStatusHistory['name'] = (string) $orderStatusHistory['name'];
            $orderStatusHistory['template'] = (string) $orderStatusHistory['template'];
            $orderStatusHistory['is_validated'] = (bool) $orderStatusHistory['is_validated'];
            $orderStatusHistory['is_delivered'] = (bool) $orderStatusHistory['is_delivered'];
            $orderStatusHistory['is_shipped'] = (bool) $orderStatusHistory['is_shipped'];
            $orderStatusHistory['is_paid'] = (bool) $orderStatusHistory['is_paid'];
            $orderStatusHistory['is_deleted'] = (bool) $orderStatusHistory['is_deleted'];
            $orderStatusHistory['created_at'] = $orderStatusHistory['date_add'];
            $orderStatusHistory['updated_at'] = $orderStatusHistory['date_add'];
        }
    }
}
