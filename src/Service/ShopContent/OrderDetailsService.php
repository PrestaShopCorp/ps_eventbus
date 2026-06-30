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
use PrestaShop\Module\PsEventbus\Repository\OrderDetailRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderDetailsService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var OrderDetailRepository */
    private $orderDetailRepository;

    public function __construct(OrderDetailRepository $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    /**
     * @param string|null $lastSeekKey
     * @param int $limit
     * @param string $langIso
     *
     * @return array{rows: array<mixed>, lastSeekKey: ?string}
     */
    public function getContentsForFull($lastSeekKey, $limit, $langIso)
    {
        $rawRows = $this->orderDetailRepository->retrieveContentsForFull($lastSeekKey, $limit, $langIso);

        $newSeekKey = $lastSeekKey;
        $rows = [];

        if (!empty($rawRows)) {
            $lastRow = end($rawRows);
            $newSeekKey = $this->padInt((int) $lastRow['id_order_detail']);

            $this->castOrderDetails($rawRows);

            $rows = array_map(function ($item) {
                return [
                    'action' => Config::INCREMENTAL_TYPE_UPSERT,
                    'collection' => Config::COLLECTION_ORDER_DETAILS,
                    'properties' => $item,
                ];
            }, $rawRows);
        }

        return [
            'rows' => $rows,
            'lastSeekKey' => $newSeekKey,
        ];
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
        $result = $this->orderDetailRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castOrderDetails($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_ORDER_DETAILS, $result, $deletedContents);
    }

    /**
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($lastSeekKey, $langIso)
    {
        return $this->orderDetailRepository->countFullSyncContentLeft($lastSeekKey, $langIso);
    }

    /**
     * @param array<mixed> $orderDetails
     *
     * @return void
     */
    private function castOrderDetails(&$orderDetails)
    {
        foreach ($orderDetails as &$orderDetail) {
            $orderDetail['id_order_detail'] = (int) $orderDetail['id_order_detail'];
            $orderDetail['id_order'] = (int) $orderDetail['id_order'];
            $orderDetail['product_id'] = (int) $orderDetail['product_id'];
            $orderDetail['product_attribute_id'] = (int) $orderDetail['product_attribute_id'];
            $orderDetail['product_quantity'] = (int) $orderDetail['product_quantity'];
            $orderDetail['unit_price_tax_incl'] = (float) $orderDetail['unit_price_tax_incl'];
            $orderDetail['unit_price_tax_excl'] = (float) $orderDetail['unit_price_tax_excl'];
            $orderDetail['refund'] = (float) $orderDetail['refund'] > 0 ? -1 * (float) $orderDetail['refund'] : 0;
            $orderDetail['refund_tax_excl'] = (float) $orderDetail['refund_tax_excl'] > 0 ? -1 * (float) $orderDetail['refund_tax_excl'] : 0;
            $orderDetail['category'] = (int) $orderDetail['category'];
            $orderDetail['unique_product_id'] = "{$orderDetail['product_id']}-{$orderDetail['product_attribute_id']}-{$orderDetail['iso_code']}";
            $orderDetail['conversion_rate'] = (float) $orderDetail['conversion_rate'];
        }
    }
}
